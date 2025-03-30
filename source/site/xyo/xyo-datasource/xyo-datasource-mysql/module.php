<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
//
// implements - Active Record Pattern
//

$className = "xyo_datasource_Mysql";

class xyo_datasource_Mysql extends xyo_Module {

	var $ds;
	var $connectionList_;
	var $dataSourceList_;

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);

		$this->ds = &$this->cloud->dataSource;

		if ($this->isBase("xyo_datasource_Mysql")) {

			require_once($this->path . "connection.php");
			require_once($this->path . "table.php");
			require_once($this->path . "query.php");
		}

		$this->connectionList_ = array();
		$this->dataSourceList_ = array();
	
	}

	function setConnection($name, $username, $password, $server, $port, $database, $prefix) {
		$this->connectionList_[$name] = new xyo_datasource_mysql_Connection($this->cloud, $this, $name, $username, $password, $server, $port, $database, $prefix);
	}

	function setConnectionProvider($name, $config){
		$this->connectionList_[$name] = new xyo_datasource_mysql_Connection($this->cloud, $this, $name,
			$config["username"],
			$config["password"],
			$config["server"],
			$config["port"],
			$config["database"],
			$config["prefix"]
		);
		if(array_key_exists("debug",$config)){
			$this->connectionList_[$name]->setDebug($config["debug"]);
		};
		if(array_key_exists("force.use",$config)){
			$this->connectionList_[$name]->setForceUse($config["force.use"]);
		};
		if(array_key_exists("log",$config)){
			$this->connectionList_[$name]->setLog($config["log"]);
		};
	}

	function hasConnection($name) {
		return array_key_exists($name, $this->connectionList_);	
	}

	function setConnectionOption($name, $option, $value) {
		$v_ = &$this->getConnection($name);
		if ($v_) {
			if (strcmp($option, "debug") == 0) {
				$v_->setDebug($value);
			} else if (strcmp($option, "force.use") == 0) {
				$v_->setForceUse($value);
			} else if (strcmp($option, "log") == 0) {
				$v_->setLog($value);
			};
		};
	}

	function getLayer() {
		return "mysql";
	}

	function setDataSourceDescriptor($name, $descriptor) {
		$this->dataSourceList_[$name] = $descriptor;
	}

	function getDataSourceList() {
		return array_keys($this->dataSourceList_);
	}

	function getDataSourceParameter($name) {
		if (array_key_exists($name, $this->dataSourceList_)) {
			return $this->dataSourceList_[$name][1];
		};
		return null;
	}

	function &getConnection($name) {
		$retV = null;
		if (array_key_exists($name, $this->connectionList_)) {
			$retV = &$this->connectionList_[$name];
		};
		return $retV;
	}

	function &getDataSource($name) { // connexion.table/query.name
		$v_ = null;
		if (!$name) {
			return $v_;
		};
		$matches = array();
		if (preg_match("/([^\\.]*)\\.([^\\.]*)\\.([^\\.]*)/", $name, $matches)) {
			if (count($matches) > 3) {
				if (array_key_exists($matches[1], $this->connectionList_)) {
					if (array_key_exists($name, $this->dataSourceList_)) {
						if ($this->dataSourceList_[$name]) {

							if (strcmp($matches[2], "table") == 0) {
								if ($this->connectionList_[$matches[1]]->open()) {
									if ($this->connectionList_[$matches[1]]->useDb()) {
										$v_ = new xyo_datasource_mysql_Table($this, $this->connectionList_[$matches[1]], $matches[3], $name, $this->dataSourceList_[$name]);
										if (!$v_->isOk()) {
											$v_ = null;
										};
									};
								};
							} else if (strcmp($matches[2], "query") == 0) {
								if ($this->connectionList_[$matches[1]]->open()) {
									if ($this->connectionList_[$matches[1]]->useDb()) {
										$v_ = new xyo_datasource_mysql_Query($this, $this->connectionList_[$matches[1]], $matches[3], $name, $this->dataSourceList_[$name]);
										if (!$v_->isOk()) {
											$v_ = null;
										};
									};
								};
							};
						};
					};
				};
			};
		};
		return $v_;
	}

	function setModuleDataSource($module, $name) {
		$descriptor = $this->cloud->getCloudPath()."datasource/" . $name . ".php";
		if (!file_exists($descriptor)) {
			$descriptor = $this->cloud->getModulePath($module);
			if ($descriptor) {
				$descriptor.="datasource/" . $name . ".php";
				if (!file_exists($descriptor)) {
					return false;
				};
			};
		};

		$this->ds->setDataSourceDescriptor($name, $descriptor);
		$this->setDataSourceDescriptor($name, $descriptor);
		return true;
	}

}

