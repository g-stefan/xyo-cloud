<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_datasource_sqlite_Table extends xyo_Config {

	var $module_;
	var $connection_;
	var $name_;
	var $datasource_;
	var $descriptor_;
	var $datasourceName_;
	//----
	var $primaryKey_;
	var $fieldType_;
	var $fieldExtra_;
	var $fieldDefaultValue_;
	var $fieldAttribute_;

	var $tableLink_;
	var $tableIndex_;
	var $cloudDataSource_;
	//----
	var $result_;
	var $fieldGroup_;
	var $fieldOrder_;
	var $orderNone;
	var $orderAscendent;
	var $orderDescendent;
	var $fieldFunction_;
	var $fieldFunctionAs_;

	var $fieldOperator_;

	var $hasNextValue_;

	var $fieldSelect_;

	var $fieldAutoIncrement_;

	var $isOk_;

	function __construct(&$module, &$connection, $name, $datasource, $descriptor, $doInit=true) {
		parent::__construct($module->getCloud());

		$this->module_ = &$module;
		$this->connection_ = &$connection;
		$this->name_ = $name;
		$this->datasource_ = $datasource;
		$this->realName_ = $connection->getPrefix().$name;		
		$this->descriptor_=$descriptor;
		
		$this->datasourceName_ = $datasource;

		$this->isOk_=false;

		if ($doInit) {
			$this->isOk_ = $this->includeFile($this->descriptor_);

			$this->realName_ = $connection->getPrefix().$this->get("name", $name);

			$this->primaryKey_ = $this->get("table_primary_key");

			$this->fieldType_ = $this->get("field_type", array());
			$this->fieldExtra_ = $this->get("field_extra", array());
			$this->fieldDefaultValue_ = $this->get("field_default_value", array());
			$this->fieldAttribute_ = $this->get("field_attribute", array());
			$this->fieldAutoIncrement_=null;

			$this->tableLink_=$this->get("table_link", array());
			$this->tableIndex_=$this->get("table_index", array());
			$this->cloudDataSource_=&$this->cloud->dataSource;

			//post-process
			$item = $this->get("table_item", array());
			foreach ($item as $k => &$v) {
				$this->fieldType_[$k]=$v[0];

				$this->fieldDefaultValue_[$k]=$v[1];
				if(count($v)>2) {
					$this->fieldAttribute_[$k]=$v[2];
					if(count($v)>3) {
						$this->fieldExtra_[$k]=$v[3];
						if($v[3]=="auto_increment") {
							$this->fieldAutoIncrement_=$k;
						};
					};
				};
			}

		};
		//---
		$this->result_ = null;

		$this->orderNone = 0;
		$this->orderAscendent = 1;
		$this->orderDescendent = 2;

		if ($doInit) {
			$this->fieldGroup_ = array();
			$this->fieldOrder_ = array();

			$this->fieldFunction_ = array();
			$this->fieldFunctionAs_ = array();

			$this->fieldOperator_ = array();

			$this->hasNextValue_ = null;

			$this->fieldSelect_=null;

			$this->setEmptyValue();
		};

		$this->backupCol_ = null;
	}

	function isOk() {
		if ($this->realName_) {
			if ($this->connection_) {
				return $this->isOk_;
			};
		};
		return false;
	}

	function getDataSourceName() {
		return $this->datasource_;
	}

	function getType() {
		return "table";
	}

	function transferTo(&$object) {
		foreach ($this->fieldType_ as $key_ => $value_) {
			if ($this->isEmpty($this->$key_)) {

			} else {
				$object->$key_ = $this->$key_;
			};
		};
	}

	function getPrimaryKey() {
		return $this->primaryKey_;
	}

	function setPrimaryKey($key) {
		$this->primaryKey_=$key;	
	}

	function getFieldType() {
		return $this->fieldType_;
	}

	function getFieldList() {
		return array_keys($this->fieldType_);
	}

	function &copyThis() {

		$retV = new xyo_datasource_sqlite_Table($this->module_, $this->connection_, $this->name_, $this->datasource_, $this->descriptor_, false);
		if ($retV) {

			$retV->isOk_ = $this->isOk_;
			$retV->realName_ =$this->realName_;
			
			$retV->primaryKey_ = &$this->primaryKey_;
			$retV->fieldType_ = &$this->fieldType_;
			$retV->fieldExtra_ = &$this->fieldExtra_;
			$retV->fieldDefaultValue_ = &$this->fieldDefaultValue_;
			$retV->fieldAttribute_ = &$this->fieldAttribute_;
			$retV->fieldAutoIncrement_=&$this->fieldAutoIncrement_;
			$retV->tableLink_ = &$this->tableLink_;
			$retV->tableIndex_ = &$this->tableIndex_;
			$retV->cloudDataSource_=&$this->cloudDataSource_;		

			$retV->fieldGroup_ = $this->fieldGroup_;
			$retV->fieldOrder_ = $this->fieldOrder_;

			$retV->fieldFunction_ = $this->fieldFunction_;
			$retV->fieldFunctionAs_ = $this->fieldFunctionAs_;

			$retV->fieldOperator_ = $this->fieldOperator_;

			$retV->fieldSelect_=$this->fieldSelect_;

			foreach ($this->fieldType_ as $key_ => $value_) {
				$retV->$key_ = $this->$key_;
			};
		};
		return $retV;
	}

	function isEmpty(&$value) {
		return ($value instanceof xyo_datasource_EmptyField);
	}

	function setEmptyValue() {
		foreach ($this->fieldType_ as $key_ => $value_) {
			$this->$key_ = new xyo_datasource_EmptyField();
		};
	}

	function getDefaultValue($name) {
		if (array_key_exists($name, $this->fieldDefaultValue_)) {
			return $this->fieldDefaultValue_[$name];
		};
		return null;
	}

	function has($name) {

		if ($this->hasValue($name)) {
			return true;
		}

		if (array_key_exists($name, $this->fieldDefaultValue_)) {
			return true;
		}

		return false;
	}

	function hasValue($name) {


		if (!$this->isEmpty($this->$name)) {
			return true;
		}

		return false;
	}

	function setOrder($key_, $value_) {
		if (array_key_exists($key_, $this->fieldType_)) {
			$this->fieldOrder_[$key_] = $value_;
			return;
		}
	}

	function setGroup($key_, $value_) {
		if (array_key_exists($key_, $this->fieldType_)) {
			$this->fieldGroup_[$key_] = $value_;
			return;
		}
	}

	function setFunctionAs($key_, $function_, $as_) {
		if (array_key_exists($key_, $this->fieldType_)) {
			$this->fieldFunction_[$key_] = $function_;
			$this->fieldFunctionAs_[$key_] = $as_;
		}
	}

	function setOperator($key_,$operator_, $v1_=null, $v2_=null,$v1x_=false,$v2x_=false) {
		if (array_key_exists($key_, $this->fieldType_)) {
			$idx=count($this->fieldOperator_);
			if($idx) {
				if($this->fieldOperator_[$idx-1][0]==0) {
					$idx=$idx-1;
				};
			} else {
				$this->pushOperator("and");
				$idx=count($this->fieldOperator_);
			};

			$opList=array(
					"between"=>array(2," BETWEEN "),
					"not-between"=>array(2," NOT BETWEEN "),
					"is-null"=>array(0," IS NULL "),
					"is-not-null"=>array(0," IS NOT NULL "),
					"="=>array(1," = "),
					"<"=>array(1," < "),
					">"=>array(1," > "),
					"<="=>array(1," <= "),
					">="=>array(1," >= "),
					"!="=>array(1," != "),
					"like"=>array(3," LIKE "));
			if(array_key_exists($operator_,$opList)) {
				$this->fieldOperator_[$idx]=array(0=>0,1=>$key_,2=>$opList[$operator_][0],3=>$opList[$operator_][1],4=>$v1_,5=>$v2_,6=>$v1x_,7=>$v2x_);
				return true;
			};
		}
		return false;
	}

	function pushOperator($mode) {
		$opList1=array(
				 "and"=>" AND ",
				 "or"=>" OR ");

		$opList2=array(
				 "("=>"(",
				 ")"=>")");

		if(array_key_exists($mode,$opList1)) {
			$idx=count($this->fieldOperator_);
			if($idx) {
				if(in_array($this->fieldOperator_[$idx-1][1],$opList1)) {
					$idx=$idx-1;
				}
			}
			$this->fieldOperator_[$idx]=array(0=>1,1=>$opList1[$mode]);
			return true;
		} else if(array_key_exists($mode,$opList2)) {
			$idx=count($this->fieldOperator_);
			if($idx) {
				if(in_array($this->fieldOperator_[$idx-1][1],$opList2)) {
					if($this->fieldOperator_[$idx-1][1]=="("&&$opList2[$mode]==")") {
						unset($this->fieldOperator_[$idx-1]);
						return true;
					};
				};
			};
			$this->fieldOperator_[$idx]=array(0=>1,1=>$opList2[$mode]);
			return true;
		}
		return false;
	}

	function getQueryValue($key_, $value_) {
		return $this->connection_->safeTypeValue($this->fieldType_[$key_], $value_);
	}

	function getQueryValueSourceCode($key_, $value_) {
		return $this->connection_->safeTypeValueSourceCode($this->fieldType_[$key_], $value_);
	}

	function getQueryWhereValue($key_, $value_) {
		return $this->connection_->safeTypeValue($this->fieldType_[$key_], $value_);
	}

	function getDefaultEmptyValue($key_) {
		return $this->connection_->safeDefaultEmptyValue($this->fieldType_[$key_]);
	}

	function setIfNotEmpty($key_, $value_) {
		if ($this->isEmpty($value_)) {
			return;
		}
		$this->$key_ = $value_;
	}


	function getWhereQuery() {
		$where = null;
		foreach ($this->fieldType_ as $key_ => $value_) {
			if ($this->isEmpty($this->$key_)) {
				continue;
			}
			if ($where) {
				$where.=" AND " . $this->getQueryWhereClauseForField($key_, $key_);
			} else {
				$where = " WHERE " . $this->getQueryWhereClauseForField($key_, $key_);
			};
		};

		if(count($this->fieldOperator_)) {
			foreach ($this->fieldOperator_ as $key_ => $value_) {
				if($value_[0]==1) {


					if ($where) {
						$where .= $value_[1];
					} else {
						$where = " WHERE ";
					}


				} else {

					if($value_[2]==1) {
						if($value_[7]) {
							$where .= "COALESCE(";
						};
					};
					$where .= "[".$value_[1]."]";
					if($value_[2]==1) {
						if($value_[7]) {
							$where .= ",".$this->getQueryValue($value_[1],$value_[5]).")";
						};
					};
					$where .= $value_[3];
					if($value_[2]==0) {
					} else if($value_[2]==1) {
						if($value_[6]) {
							$where.= "[".$value_[4]."]";
						} else {
							$where.= $this->getQueryValue($value_[1],$value_[4]);
						};
					} else if($value_[2]==2) {
						if($value_[6]) {
							$where.= "[".$value_[4]."]";
						} else {
							$where.= $this->getQueryValue($value_[1],$value_[4]);
						};

						$where.=" AND ";

						if($value_[7]) {
							$where.= "[".$value_[5]."]";
						} else {
							$where.= $this->getQueryValue($value_[1],$value_[5]);
						};
					} else if($value_[2]==3) {
						if($value_[6]) {
							$where.= "[".$value_[4]."]";
						} else {
							$where.= "'%" . $this->connection_->safeLikeValue($value_[4]) . "%'";
						};
					}

				}
			}
		}

		return $where;
	}


	function getLoadQuery($query=false, $inCount=false) {

		if ($query == false) {

			if(empty($this->fieldSelect_)) {

				foreach ($this->fieldType_ as $key_ => $value_) {
					if ($query) {
						$query.=",[" . $key_ . "] AS [" . $key_ . "]";
					} else {
						$query = "SELECT [" . $key_ . "] AS [" . $key_ . "]";
					};
				}

			} else {

				foreach ($this->fieldSelect_ as $key_) {
					if ($query) {
						$query.=",[" . $key_ . "] AS [" . $key_ . "]";
					} else {
						$query = "SELECT [" . $key_ . "] AS [" . $key_ . "]";
					};
				}

			}

			foreach ($this->fieldFunction_ as $key_ => $value_) {
				$query.="," . $value_ . "([" . $key_ . "]) AS [" . $this->fieldFunctionAs_[$key_] . "]";
			};
		};

		$query.=" FROM [" . $this->realName_ . "]";
		$query.=$this->getWhereQuery();

		$group = false;
		foreach ($this->fieldGroup_ as $key_ => $value_) {
			if ($value_) {
				if ($group) {
					$group.=",[" . $key_ . "]";
				} else {
					$group = "GROUP BY [" . $key_ . "]";
				};
			};
		};
		if ($group) {
			$query.=" " . $group;
		};


		if ($inCount) {

		} else {

			$order = false;
			foreach ($this->fieldOrder_ as $key_ => $value_) {
				if ($value_) {
					if ($order) {
						$order.=",[" . $key_ . "]";

						if ($value_ == $this->orderAscendent) {
							$order.=" ASC";
						} else if ($value_ == $this->orderDescendent) {
							$order.=" DESC";
						};
					} else {
						$order = "ORDER BY [" . $key_ . "]";
						if ($value_ == $this->orderAscendent) {
							$order.=" ASC";
						} else if ($value_ == $this->orderDescendent) {
							$order.=" DESC";
						};
					};
				};
			};

			if ($order) {
				$query.=" " . $order;
			};
		};

		return $query;
	}


	function update($what_=array()) {
		if(count($what_)) {

			$query = false;
			foreach ($what_ as $key_ => $value_) {
				if (is_array($value_)) {
					continue;
				}
				if ($this->isEmpty($value_)) {
					continue;
				}

				if ($query) {
					$query.=",[" . $key_ . "]=" . $this->getQueryValue($key_, $value_);
				} else {
					$query = "UPDATE [" . $this->realName_ . "] SET [" . $key_ . "]=" . $this->getQueryValue($key_, $value_);
				};
			};


			$query.=$this->getWhereQuery();


			$result = $this->connection_->queryDirect($query);
			if ($result) {
				return true;
			};

		}
		return false;
	}

	function save() {

		if($this->primaryKey_) {

			$tablePrimaryKeyValue = $this-> {$this->primaryKey_};
			if (is_array($tablePrimaryKeyValue)) {
				$tablePrimaryKeyValue = null;
			};
			if ($tablePrimaryKeyValue == $this->fieldDefaultValue_[$this->primaryKey_]) {
				$tablePrimaryKeyValue = null;
			};
			if ($this->isEmpty($tablePrimaryKeyValue)) {
				$tablePrimaryKeyValue = null;
			};

			if ($tablePrimaryKeyValue) {

				$query = false;
				foreach ($this->fieldType_ as $key_ => $value_) {
					if (is_array($this->$key_)) {
						continue;
					}
					if ($this->isEmpty($this->$key_)) {
						continue;
					}

					if ($query) {
						$query.=",[" . $key_ . "]=" . $this->getQueryValue($key_, $this->$key_);
					} else {
						$query = "UPDATE [" . $this->realName_ . "] SET [" . $key_ . "]=" . $this->getQueryValue($key_, $this->$key_);
					};
				};
				$query.=" WHERE [" . $this->primaryKey_ . "]=" . $this->getQueryValue($this->primaryKey_, $tablePrimaryKeyValue) . ";";


				$result = $this->connection_->queryDirect($query);
				if ($result) {
					return true;
				};
				return false;
			};

		};

		return $this->insert();
	}

	function insert() {
		$query = false;
		$queryV = false;
		foreach ($this->fieldType_ as $key_ => $value_) {
			$value = $this->$key_;
			if (is_array($value)) {
				$value = null;
			}
			if ($this->isEmpty($this->$key_)) {
				$value = $this->fieldDefaultValue_[$key_];
			}


			if ($query) {
				$query.=",[" . $key_ . "]";
			} else {
				$query = "INSERT INTO [" . $this->realName_ . "] ([" . $key_ . "]";
			};

			if ($queryV) {
				$queryV.="," . $this->getQueryValue($key_, $value);
			} else {
				$queryV = "VALUES (" . $this->getQueryValue($key_, $value);
			};
		};
		$query.=") " . $queryV . ");";

		$result = $this->connection_->queryDirect($query);
		if ($result) {
			if($this->fieldAutoIncrement_) {
				$query="SELECT last_insert_rowid();";
				$value=$this->connection_->queryValueDefaultDirect($query, null);
				if ($value) {
					$this-> {$this->fieldAutoIncrement_}= $value;
				};
			};
			return true;
		};
		return false;
	}

	function getQueryWhereClauseForFieldOnValue($field_as, $field_this, $value_) {

		$where = "[" . $field_as . "]";
		$where.="=" . $this->getQueryValue($field_this, $value_);

		return $where;
	}

	function getQueryWhereClauseForField($field_as, $field_this) {
		$value_ = $this->$field_this;
		if (is_array($value_)) {
			if (count($value_) == 1) {
				$value_ = $value_[0];
			} else {
				$where = "(";

				$x = null;
				foreach ($value_ as $v) {
					if ($x) {
						$x.=" OR " . $this->getQueryWhereClauseForFieldOnValue($field_as, $field_this, $v);
					} else {
						$x = $this->getQueryWhereClauseForFieldOnValue($field_as, $field_this, $v);
					};
				};

				$where.=$x;
				$where.=")";
				return $where;
			};
		};

		return $this->getQueryWhereClauseForFieldOnValue($field_as, $field_this, $value_);
	}

	function prepareLink($name) {
		if(array_key_exists($name,$this->tableLink_)) {
			$ds=&$this->cloudDataSource_->getDataSource($this->tableLink_[$name][0]);
			$ds->clear();
			$ds-> {$this->tableLink_[$name][1]}=$this-> {$this->tableLink_[$name][2]};
			return $ds;
		};
		return null;
	}


	function delete() {
		if ($this->isValid()) {

			if(count($this->tableLink_)) {
				foreach($this->tableLink_ as $key=>$value) {
					$ds=&$this->cloudDataSource_->getDataSource($value[0]);
					$ds-> {$value[1]}=$this-> {$value[2]};
					for($ds->load(); $ds->isValid(); $ds->loadNext()) {
						if($value[3]==="delete") {
							$ds->delete();
						} else if($value[3]==="set") {
							$ds-> {$value[1]}=$value[4];
							$ds->save();
						};
					};
				};
			};


			//--- this

			$query = false;

			if($this->primaryKey_) {
				if (!$this->isEmpty($this-> {$this->primaryKey_})) {
					$query = "DELETE FROM [" . $this->realName_ . "] WHERE " . $this->getQueryWhereClauseForField($this->primaryKey_, $this->primaryKey_);
					$query.=";";

					$result = $this->connection_->queryDirect($query);
					if ($result) {
						return true;
					};
					return false;
				};
			};

			foreach ($this->fieldType_ as $key_ => $value_) {
				if (!$this->isEmpty($this->$key_)) {
					if ($query) {
						$query.=" AND " . $this->getQueryWhereClauseForField($key_, $key_);
					} else {
						$query = "DELETE FROM [" . $this->realName_ . "] WHERE " . $this->getQueryWhereClauseForField($key_, $key_);
					};
				};
			};

			$query.=";";

			$result = $this->connection_->queryDirect($query);
			if ($result) {
				return true;
			};
		};
		return false;
	}


	function load($start=null, $length=null) {
		return $this->loadDirectCode($this->getLoadDirectCode($start, $length));
	}

	function tryLoad($start=null, $length=null) {
		return $this->tryLoadDirectCode($this->getLoadDirectCode($start, $length));
	}

	function getLoadDirectCode($start=null, $length=null) {

		if($this->primaryKey_) {
			if (is_null($this-> {$this->primaryKey_})) {
				if (($this->fieldType_[$this->primaryKey_] === "int")||
				    ($this->fieldType_[$this->primaryKey_] === "bigint")) {
					$this-> {$this->primaryKey_} = new xyo_datasource_EmptyField();
				};
			};
		};

		$query = $this->getLoadQuery();

		if (isset($start)) {
			$query.=" LIMIT " . $start;

			if ($length) {
				$query.="," . $length;
			} else {

			};
		} else {

		};


		$query.=";";

		return $query;
	}

	function loadDirectCode($query) {

		$this->result_ = $this->connection_->queryDirect($query);
		if ($this->result_) {
			$fieldValue_ = $this->result_->fetchArray(SQLITE3_ASSOC);
			if ($fieldValue_) {
				if(!empty($this->fieldSelect_)) {
					$this->setEmptyValue();
				};
				foreach ($fieldValue_ as $key_ => $value_) {
					$this->$key_ = $value_;
				};
				return true;
			};
		};
		$this->setEmptyValue();
		return false;
	}

	function tryLoadDirectCode($query) {

		$this->result_ = $this->connection_->queryDirect($query);
		if ($this->result_) {
			$fieldValue_ = $this->result_->fetchArray(SQLITE3_ASSOC);
			if ($fieldValue_) {
				if(!empty($this->fieldSelect_)) {
					$this->setEmptyValue();
				};
				foreach ($fieldValue_ as $key_ => $value_) {
					$this->$key_ = $value_;
				};
				return true;
			};
		};
		$this->result_ = null;
		return false;
	}

	function count() {
		$query = $this->getLoadQuery("SELECT COUNT(*)", true);
		return $this->connection_->queryValueDefaultDirect($query, 0);
	}

	function isValid() {
		foreach ($this->fieldType_ as $key_ => $value_) {
			if (!$this->isEmpty($this->$key_)) {
				return true;
			};
		};
		return false;
	}

	function hasNext() {
		if ($this->result_) {
			$this->hasNextValue_ = $this->result_->fetchArray(SQLITE3_ASSOC);
			if($this->hasNextValue_) {
				return true;
			}
		}
		return false;
	}

	function loadNext() {
		if($this->hasNextValue_) {
			if(!empty($this->fieldSelect_)) {
				$this->setEmptyValue();
			};
			foreach ($this->hasNextValue_ as $key_ => $value_) {
				$this->$key_ = $value_;
			};
			$this->hasNextValue_=null;
			return true;
		};
		if ($this->result_) {
			$fieldValue_ = $this->result_->fetchArray(SQLITE3_ASSOC);
			if ($fieldValue_) {
				if(!empty($this->fieldSelect_)) {
					$this->setEmptyValue();
				};
				foreach ($fieldValue_ as $key_ => $value_) {
					$this->$key_ = $value_;
				};
				return true;
			};
		};
		$this->setEmptyValue();
		return false;
	}

	function clear($key_=false) {
		if ($key_) {

			if (array_key_exists($key_, $this->fieldType_)) {
				$this->$key_ = new xyo_datasource_EmptyField();
			};
			if (array_key_exists($key_, $this->fieldGroup_)) {
				unset($this->fieldGroup_[$key_]);
			};
			if (array_key_exists($key_, $this->fieldOrder_)) {
				unset($this->fieldOrder_[$key_]);
			};
			if (array_key_exists($key_, $this->fieldFunction_)) {
				unset($this->fieldFunction_[$key_]);
			};
			if (array_key_exists($key_, $this->fieldFunctionAs_)) {
				unset($this->fieldFunctionAs_[$key_]);
			};

		} else {
			$this->setEmptyValue();
			$this->fieldGroup_ = array();
			$this->fieldOrder_ = array();

			$this->fieldFunction_ = array();
			$this->fieldFunctionAs_ = array();

			$this->fieldOperator_ = array();

			$this->fieldSelect_=null;
		};
	}

	function destroyStorage() {
		$query = "SELECT [name] FROM [sqlite_master] WHERE [name]=\"" . $this->realName_ . "\";";
		$result = $this->connection_->queryValueDefaultDirect($query, null);
		if ($result) {
			$query = "DROP TABLE [" . $this->realName_ . "];";
			$result = $this->connection_->queryDirect($query);
			if ($result) {
				return true;
			}
			return false;
		};
		return true;
	}

	function createStorage() {
		$query = "SELECT [name] FROM [sqlite_master] WHERE [name]=\"" . $this->realName_ . "\";";
		$result = $this->connection_->queryValueDefaultDirect($query, null);
		if ($result) {
			return true;
		};

		$before = false;
		$query = "CREATE TABLE [" . $this->realName_ . "] (";
		foreach ($this->fieldType_ as $key_ => $value_) {

			if ($before) {
				$query.=",";
			} else {
				$before = true;
			};


			$x = true;
			if (strcmp($this->primaryKey_, $key_) == 0) {
				if (strcmp($value_, "int") == 0) {

					$query.="[" . $key_ . "] INTEGER PRIMARY KEY ASC";
					$x = false;
				} else if (strcmp($value_, "bigint") == 0) {

					$query.="[" . $key_ . "] INTEGER PRIMARY KEY ASC";
					$x = false;
				};

			};


			if ($x) {

				$query.="[" . $key_ . "] " . strtoupper($value_);
				if (array_key_exists($key_, $this->fieldAttribute_)) {
					if($value_=="varchar") {
						$query.="(" . strtoupper($this->fieldAttribute_[$key_]).")";
					} else {
						$query.=" " . strtoupper($this->fieldAttribute_[$key_]);
					};
				};

				if (array_key_exists($key_, $this->fieldExtra_)) {
					if (strcmp($this->fieldExtra_[$key_], "auto_increment") == 0) {
						$query.=" AUTOINCREMENT";
					} else {
						$query.=" " . strtoupper($this->fieldExtra_[$key_]);
					};
				};

				if (array_key_exists($key_, $this->fieldDefaultValue_)) {
					if (strcmp($this->fieldDefaultValue_[$key_], "DEFAULT") == 0) {

					} else if (is_int($this->fieldDefaultValue_[$key_])) {
						$query.=" DEFAULT " . $this->fieldDefaultValue_[$key_];
					} else if (is_null($this->fieldDefaultValue_[$key_])) {

					} else {
						$query.=" DEFAULT '" . $this->fieldDefaultValue_[$key_] . "'";
					};
				};
			};
		};

		$query.=");";

		$result = $this->connection_->queryDirect($query);
		if ($result) {
			return $this->createStorageIndex();
		}
		return false;
	}

	function createStorageIndex() {
		if (count($this->tableIndex_)==0) {
			return true;
		};
		foreach($this->tableIndex_ as $index) {
			$query="CREATE INDEX '".$this->realName_."_" . $index . "' ON '" . $this->realName_ . "' ('" . $index . "')";
			$result = $this->connection_->queryDirect($query);
			if ($result) {
				continue;
			}
			return false;
		};
		return true;
	}

	function recreateStorage() {
		$this->destroyStorage();
		return $this->createStorage();
	}

	function strDataSource() {
		$retV = "Array\r\n(\r\n";
		foreach ($this->fieldType_ as $key_ => $value_) {
			if ($this->isEmpty($this->$key_)) {
				$retV.="\t[" . $key_ . "] => [empty]\r\n";
			} else if (is_array($this->$key_)) {
				$retV.="\t[" . $key_ . "] => Array\r\n\t(\r\n";
				foreach ($this->$key_ as $k_ => $v_) {
					$retV.="\t\t[" . $k_ . "] => " . $v_ . "\r\n";
				};
				$retV.="\t)\r\n";
			} else {
				$retV.="\t[" . $key_ . "] => " . $this->$key_ . "\r\n";
			};
		};
		foreach ($this->fieldFunctionAs_ as $key_) {
			if ($this->isEmpty($this->$key_)) {
				$retV.="\t[" . $key_ . "] => [empty]\r\n";
			} else {
				$retV.="\t[" . $key_ . "] => " . $this->$key_ . "\r\n";
			};
		};
		$retV.=")\r\n";
		return $retV;
	}

	function batch($what_=array()) {
		if(count($what_)) {
			foreach($what_ as $item_) {
				foreach($item_ as $key_=>$value_) {
					if(!is_array($value_)) {
						return false;
					};

					$this->clear();

					if($key_==="update") {
						if(is_array($value_[0])&&is_array($value_[1])) {
							foreach($value_[0] as $key2=>$value2) {
								$this->$key2=$value2;
							};
							if(!$this->update($value_[1])){
								return false;
							};
							continue;
						};
						return false;
					};

					if($key_==="try-save") {
						if(is_array($value_[0])&&is_array($value_[1])) {
							foreach($value_[0] as $key2=>$value2) {
								$this->$key2=$value2;
							};
							$this->tryLoad();
							foreach($value_[1] as $key2=>$value2) {
								$this->$key2=$value2;
							};
							if(!$this->save()){
								return false;
							};
							continue;
						};
						return false;
					};

					foreach($value_ as $key2=>$value2) {
						$this->$key2=$value2;
					};

					if($key_==="save") {
						if(!$this->save()){
							return false;
						};
						continue;
					};

					if($key_==="insert") {
						if(!$this->insert()){
							return false;
						};
						continue;
					};

					if($key_==="delete") {
						if(!$this->delete()){
							return false;
						};
						continue;
					};
				};
			};
			return true;
		};
		return false;
	}

	function select($what=null) {
		$this->fieldSelect_=$what;
	}

	function clearWithNull() {
		foreach ($this->fieldType_ as $key_ => $value_) {
			$this->$key_ = null;
		};
		$this->fieldGroup_ = array();
		$this->fieldOrder_ = array();
		$this->fieldFunction_ = array();
		$this->fieldFunctionAs_ = array();
		$this->fieldOperator_ = array();
		$this->fieldSelect_=null;
	}

	function getStorageName(){
		return $this->get("name", $this->name_);
	}

	function setStorageName($name){
		$this->set("name", $name);
		$this->name_ = $name;
		$this->realName_ = $this->connection_->getPrefix().$name;
	}

	function setKeyAtIndex($arrayInput,$key,$value,$index){
		if(is_null($index)){
			$arrayInput[$key]=$value;
			return $arrayInput;
		};
		$scanKey=array_keys($arrayInput);
		$countKey=count($scanKey);
		for($scanIndex=0;$scanIndex<$countKey;++$scanIndex){
			if($scanKey[$scanIndex]==$key){
				break;
			};
		};
		$retV=array();		
		for($k=0;$k<$index;++$k){
			if($k==$scanIndex){
				continue;
			};
			$retV[$scanKey[$k]]=$arrayInput[$scanKey[$k]];
		};
		$retV[$key]=$value;
		for(;$k<$countKey;++$k){
			if($k==$scanIndex){
				continue;
			};
			$retV[$scanKey[$k]]=$arrayInput[$scanKey[$k]];
		};
		return $retV;		
	}

	function setField($name,$type,$defaultValue,$attribute=null,$extra=null,$atIndex=null){

		$this->$name = new xyo_datasource_EmptyField();
		
		$this->fieldType_=$this->setKeyAtIndex($this->fieldType_,$name,$type,$atIndex);				
		
		$this->fieldAttribute_[$name]=$attribute;
		$this->fieldDefaultValue_[$name]=$defaultValue;		
		$this->fieldExtra_[$name]=$extra;
		if($extra=="auto_increment"){
			$this->fieldAutoIncrement_=$name;
		};
	}

	function atomicAdd($field,$value) {

		if($this->primaryKey_) {

			$tablePrimaryKeyValue = $this-> {$this->primaryKey_};
			if (is_array($tablePrimaryKeyValue)) {
				$tablePrimaryKeyValue = null;
			};
			if ($tablePrimaryKeyValue === $this->fieldDefaultValue_[$this->primaryKey_]) {
				$tablePrimaryKeyValue = null;
			};
			if ($this->isEmpty($tablePrimaryKeyValue)) {
				$tablePrimaryKeyValue = null;
			};

			if ($tablePrimaryKeyValue) {

				$query = "BEGIN TRANSACTION;";
				$query .= "SELECT [".$field."] FROM [".$this->realName_."] WHERE [".$this->primaryKey_."] = ".$tablePrimaryKeyValue." FOR UPDATE;";
				$query .= "UPDATE [".$this->realName_."] SET [".$field."] = [".$field."]+".$value." WHERE [".$this->primaryKey_."] = ".$tablePrimaryKeyValue.";";
				$query .= "COMMIT;";

				$result = $this->connection_->queryDirect($query);
				if ($result) {
					return true;
				};
			};

		};
		
		return false;
	}

	function atomicIncrement($field){
		return $this->atomicAdd($field,1);
	}

	function atomicSub($field,$value) {

		if($this->primaryKey_) {

			$tablePrimaryKeyValue = $this-> {$this->primaryKey_};
			if (is_array($tablePrimaryKeyValue)) {
				$tablePrimaryKeyValue = null;
			};
			if ($tablePrimaryKeyValue === $this->fieldDefaultValue_[$this->primaryKey_]) {
				$tablePrimaryKeyValue = null;
			};
			if ($this->isEmpty($tablePrimaryKeyValue)) {
				$tablePrimaryKeyValue = null;
			};

			if ($tablePrimaryKeyValue) {

				$query = "BEGIN TRANSACTION;";
				$query .= "SELECT [".$field."] FROM [".$this->realName_."] WHERE [".$this->primaryKey_."] = ".$tablePrimaryKeyValue." FOR UPDATE;";
				$query .= "UPDATE [".$this->realName_."] SET [".$field."] = [".$field."]-".$value." WHERE [".$this->primaryKey_."] = ".$tablePrimaryKeyValue.";";
				$query .= "COMMIT;";

				$result = $this->connection_->queryDirect($query);
				if ($result) {
					return true;
				};
			};

		};
		
		return false;
	}

	function atomicDecrement($field){
		return $this->atomicSub($field,1);
	}

	function storageRemoveField($name) {
		$query = "ALTER TABLE [" . $this->realName_ . "] DROP COLUMN [".$name."];";
		$result = $this->connection_->queryDirect($query);
		if ($result) {
			return true;
		}
		return false;		
	}

	function storageRenameField($oldName, $newName) {
		$query = "ALTER TABLE [" . $this->realName_ . "] CHANGE COLUMN [".$oldName."] [".$newName."];";
		$result = $this->connection_->queryDirect($query);
		if ($result) {
			return true;
		}
		return false;		
	}

	function storageUpdateField($name) {
		$query = "ALTER TABLE [" . $this->realName_ . "] MODIFY ";

		$key_ = $name;
		$value_ = $this->fieldType_[$name];

		$query.="[" . $key_ . "] " . strtoupper($value_);

		$x = true;
		if (strcmp($this->primaryKey_, $key_) == 0) {
			if (strcmp($value_, "int") == 0) {
				$query.="[" . $key_ . "] INTEGER PRIMARY KEY ASC";
				$x = false;
			} else if (strcmp($value_, "bigint") == 0) {
				$query.="[" . $key_ . "] INTEGER PRIMARY KEY ASC";
				$x = false;
			};
		};

		if ($x) {

			$query.="[" . $key_ . "] " . strtoupper($value_);
			if (array_key_exists($key_, $this->fieldAttribute_)) {
				if($value_=="varchar") {
					$query.="(" . strtoupper($this->fieldAttribute_[$key_]).")";
				} else {
					$query.=" " . strtoupper($this->fieldAttribute_[$key_]);
				};
			};

			if (array_key_exists($key_, $this->fieldExtra_)) {
				if (strcmp($this->fieldExtra_[$key_], "auto_increment") == 0) {
					$query.=" AUTOINCREMENT";
				} else {
					$query.=" " . strtoupper($this->fieldExtra_[$key_]);
				};
			};

			if (array_key_exists($key_, $this->fieldDefaultValue_)) {
				if (strcmp($this->fieldDefaultValue_[$key_], "DEFAULT") == 0) {

				} else if (is_int($this->fieldDefaultValue_[$key_])) {
					$query.=" DEFAULT " . $this->fieldDefaultValue_[$key_];
				} else if (is_null($this->fieldDefaultValue_[$key_])) {

				} else {
					$query.=" DEFAULT '" . $this->fieldDefaultValue_[$key_] . "'";
				};
			};
		}

		$query.= ";";
		$result = $this->connection_->queryDirect($query);
		if ($result) {
			return true;
		}
		return false;		
	}
}

