<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_datasource_postgresql_Connection {

	var $db;
	var $debug;
	var $log;
	var $cloud;
	var $module;
	var $name;
	var $server;
	var $port;
	var $user;
	var $password;
	var $database;
	var $prefix;	
	
	function __construct(&$cloud, &$module, $name, $user, $password, $server,$port, $database, $prefix) {
		$this->cloud = &$cloud;
		$this->module = &$module;
		$this->name = $name;
		$this->user = $user;
		$this->password = $password;
		$this->server = $server;
		$this->port = $port;
		$this->database = $database;
		$this->prefix = $prefix;

		$this->db = null;
		$this->debug = false;
		$this->log = false;
	}

	function setLog($log) {
		$this->log = $log;
	}

	function setDebug($debug) {
		$this->debug = $debug;
	}

	function getDateNow() {
		return date("Y-m-d H:i:s");
	}

	function getPrefix() {
		return $this->prefix;
	}

	function debug() {
		if ($this->debug) {
			if ($this->db) {
				echo pg_last_error();
			};
		};
	}

	function debug2() {
		if ($this->debug) {
			if ($this->db) {
				echo "on:" . $query . "\n";
				echo pg_last_error($this->db);
			};
		};
	}

	function open() {
		if ($this->db) {
			return true;
		}
		$this->db = @pg_connect("host=" . $this->server . " port=" . $this->port . " dbname=" . $this->database . " user=" . $this->user . " password=" . $this->password);
		if (!$this->db) {
			$this->db = null;
			return false;
		};
		return true;
	}

	function close() {
		if ($this->db) {
			pg_close($this->db);
			$this->db = null;
		}
	}

	function postgresqlQuery_($query) {
		if ($this->log) {

			$retV = pg_query($this->db, $query);

			$fs = fopen("log/postgresql." . $this->name . ".log", "ab");
			if ($fs) {
				fwrite($fs, date("Y-m-d H:i:s") . "\n");
				fwrite($fs, $query);
				fwrite($fs, "\n");
				if ($retV) {
					fwrite($fs, "Ok\n");
				} else {
					fwrite($fs, "Fail\n");
					fwrite($fs, pg_last_error($this->db)."\n");
				};
				fwrite($fs, "\n");
				fclose($fs);
			};

			return $retV;
		};
		return pg_query($this->db, $query);
	}

	function queryDirect2($query) {
		return pg_query($this->db, $query);
	}

	function queryDirect($query) {
		$result = $this->postgresqlQuery_($query);
		if (!$result) {
			$this->debug2($query);
			$result = null;
		};
		return $result;
	}

	function query($query) {
		$query = $this->parseQuery($query);
		if ($query) {
			return $this->queryDirect($query);
		};
		return null;
	}

	function safeTypeValue($type_, $value_) {
		if ($type_ == "int") {
			if (strcmp($value_, "DEFAULT") == 0) {
				return "DEFAULT";
			}
			return $this->safeValue(1 * $value_);
		} else if ($type_ == "bigint") {
			if (strcmp($value_, "DEFAULT") == 0) {
				return "DEFAULT";
			}
			return $this->safeValue(1 * $value_);
		} else if ($type_ == "float") {
			if (strcmp($value_, "DEFAULT") == 0) {
				return "DEFAULT";
			}
			return $this->safeValue(1 * $value_);
		} else if ($type_ == "text") {
			if (is_null($value_)) {
				return "NULL";
			};
			return "'" . $this->safeValue($value_) . "'";
		} else if ($type_ == "varchar") {
			if (is_null($value_)) {
				return "NULL";
			};
			return "'" . $this->safeValue($value_) . "'";
		} else if ($type_ == "date") {
			if (is_null($value_)) {
				return "NULL";
			};
			if ($value_ == "NOW") {
				return "CURDATE()";
			};
			return "'" . $this->safeValue($value_) . "'";
		} else if ($type_ == "time") {
			if (is_null($value_)) {
				return "NULL";
			};
			if ($value_ == "NOW") {
				return "CURTIME()";
			};
			return "'" . $this->safeValue($value_) . "'";
		} else if ($type_ == "datetime") {
			if (is_null($value_)) {
				return "NULL";
			};
			if ($value_ == "NOW") {
				return "NOW()";
			};
			return "'" . $this->safeValue($value_) . "'";
		};
		return null;
	}

	function safeDefaultEmptyValue($type_) {
		if (($this->fieldType_[$type_] == "int")||($this->fieldType_[$type_] == "bigint")) {
			return 0;
		} else {
			return null;
		}
	}

	function queryValue($query, $default_=null) {
		$result = $this->query($query);
		if ($result) {
			$data = pg_fetch_row($result);
			if ($data) {
				return $data[0];
			};
		};
		return $default_;
	}

	function queryValueDefaultDirect($query, $default_) {
		$result = $this->postgresqlQuery_($query);
		if (!$result) {
			$this->debug2($query);
			return $default_;
		};
		$data = pg_fetch_row($result);
		if ($data) {
			return $data[0];
		};
		return $default_;
	}

	function queryAssoc($query) {
		$result = $this->query($query);
		if ($result) {
			$data = pg_fetch_assoc($result);
			if ($data) {
				return $data;
			};
		};
		return false;
	}

	function parseQuery($query) {
		// extract #(name),check,replace #(name) with `table`
		$allOk = true;
		$replaceSource = array();
		$replaceDestination = array();
		$regex_pattern = "/#\(`([^`\)]*)`\)/";
		if (preg_match_all($regex_pattern, $query, $matches) >= 1) {
			foreach ($matches[1] as $match) {
				$table = $this->module->getDataSourceParameter($this->name . ".table." . $match);
				if ($table) {
					$replaceSource[] = "#(`" . $match . "`)";
					$replaceDestination[] = "\"" . $table . "\"";
				} else {
					$allOk = false;
					break;
				};
			};
			if ($allOk) {
				return str_replace($replaceSource, $replaceDestination, $query);
			};
		} else {
			return $query;
		};
		return false;
	}

	function safeQuery($query, $params) {
		// extract @(name),check,replace @(name) with safe `value`
		$allOk = true;
		$replaceSource = array();
		$replaceDestination = array();
		$regex_pattern = "/@\(`([^`\)]*)`\)/";
		if (preg_match_all($regex_pattern, $query, $matches) >= 1) {
			foreach ($matches[1] as $match) {
				$value = array_key_exists($match, $params);
				if ($value) {
					$replaceSource[] = "@(`" . $match . "`)";
					$replaceDestination[] = $this->safeValue($params[$match]);
				} else {
					$allOk = false;
					break;
				};
			};
			if ($allOk) {
				return $this->parseQuery(str_replace($replaceSource, $replaceDestination, $query));
			};
		} else {
			return $this->parseQuery($query);
		};
		return false;
	}

	function safeValue($value) {
		return pg_escape_string($this->db, $value);
	}

	function safeLikeValue($value) {
		return addcslashes(pg_escape_string($this->db, $value), "%_");
	}
	
	function destroyStorage($storage) {		
		$query = "DROP TABLE IF EXISTS \"".$this->prefix.$storage."\";";
		$result = $this->queryDirect($query);
		if ($result) {
			return true;
		}
		return false;
	}

	function renameStorage($oldName,$newName) {
		$query = "ALTER TABLE \"".$this->prefix.$oldName."\" RENAME TO \"".$this->prefix.$newName."\";";
		$result = $this->queryDirect($query);
		if ($result) {
			return true;
		}
		return false;
	}
}

