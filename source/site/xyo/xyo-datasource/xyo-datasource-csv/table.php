<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
//
// to do file lock/wait ..
//
// result compare
//
function xyo_datasource_csv_table__cmp($a, $b) {
	foreach ($a["*"] as $key_ => $value_) {
		if ($value_ == 1) { //asc
			if ($a[$key_] > $b[$key_]) {
				return 1;
			}
			if ($a[$key_] < $b[$key_]) {
				return -1;
			}
		} else if ($value_ == 2) { //desc
			if ($a[$key_] > $b[$key_]) {
				return -1;
			}
			if ($a[$key_] < $b[$key_]) {
				return 1;
			}
		};
	};
	return 0;
}


class xyo_datasource_csv_Table extends xyo_Config {

	var $module_;
	var $connection_;
	var $name_;
	var $datasource_;
	var $realName_;	
	var $datasourceName_;
	var $descriptor_;
	//----
	var $primaryKey_;
	var $fieldType_;
	var $fieldExtra_;
	var $fieldDefaultValue_;
	var $fieldAttribute_;
	var $tableLink_;
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

	//----
	var $resultCol_;
	var $resultRow_;
	var $resultCount_;
	var $resultLimitStart_;
	var $resultLimitLength_;
	var $resultLoadAll_;
	var $resultPrimaryKeyIndex_;
	var $resultInLoadIndex_;
	var $resultInLoadCount_;
	var $resultInLoad_;
	var $fileName_;
	var $storageHint_;

	var $fieldSelect_;

	var $fieldAutoIncrement_;
	var $isOk_;
	
	function __construct(&$module, &$connection, $name, $datasource, $descriptor, $doInit=true) {
		parent::__construct($module->getCloud());

		$this->module_ = &$module;
		$this->connection_ = &$connection;
		$this->name_ = $name;
		$this->datasource_ = $datasource;
		$this->realName_ = $name;		
		$this->descriptor_=$descriptor;		

		$this->datasourceName_ = $datasource;
		$this->isOk_=false;

		if ($doInit) {
			$this->isOk_ = $this->includeFile($this->descriptor_);
				
			$this->realName_ = $this->get("name", $name);

			$this->storageHint_=$this->realName_;
			$this->fileName_ = $this->connection_->databasePath . $this->realName_ . ".csv";

			$this->primaryKey_ = $this->get("table_primary_key");

			$this->fieldType_ = $this->get("field_type", array());
			$this->fieldExtra_ = $this->get("field_extra", array());
			$this->fieldDefaultValue_ = $this->get("field_default_value", array());
			$this->fieldAttribute_ = $this->get("field_attribute", array());
			$this->fieldAutoIncrement_=null;


			$this->tableLink_=$this->get("table_link", array());
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

		$this->resultCol_ = array();
		$this->resultRow_ = array();
		$this->resultPrimaryKeyIndex_ = 0;

		if ($doInit) {

			$this->fieldGroup_ = array();
			$this->fieldOrder_ = array();

			$this->fieldFunction_ = array();
			$this->fieldFunctionAs_ = array();

			$this->fieldOperator_ = array();

			$this->fieldSelect_=null;

			$this->setEmptyValue();
		};
	}

	function setStorageHint($hint) {
		$this->storageHint_=$hint;
		$this->fileName_ = $this->connection_->databasePath . $hint . ".csv";
	}

	function getStorageHint() {
		return $this->storageHint_;
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

		$retV = new xyo_datasource_csv_Table($this->module_, $this->connection_, $this->name_, $this->datasource_, $this->descriptor_, false);
		if ($retV) {
			
			$retV->isOk_ = $this->isOk_;
			$retV->realName_ =$this->realName_;

			$retV->storageHint_=$this->storageHint_;

			$retV->fileName_ = $this->fileName_;

			$retV->primaryKey_ = &$this->primaryKey_;
			$retV->fieldType_ = &$this->fieldType_;
			$retV->fieldExtra_ = &$this->fieldExtra_;
			$retV->fieldDefaultValue_ = &$this->fieldDefaultValue_;
			$retV->fieldAttribute_ = &$this->fieldAttribute_;
			$retV->fieldAutoIncrement_=&$this->fieldAutoIncrement_;
			$retV->tableLink_ = &$this->tableLink_;
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

	function getType() {
		return "table";
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
			if ($value_ != $this->orderNone) {
				$this->fieldOrder_[$key_] = $value_;
			} else {
				unset($this->fieldOrder_[$key_]);
			};
			return;
		}
	}

	function setGroup($key_, $value_) {
		if (array_key_exists($key_, $this->fieldType_)) {
			if ($value_) {
				$this->fieldGroup_[$key_] = $value_;
			} else {
				unset($this->fieldGroup_[$key_]);
			};
			return;
		}
	}

	function setFunctionAs($key_, $function_, $as_) {
		if (array_key_exists($key_, $this->fieldType_)) {
			$this->fieldFunction_[$key_] = $function_;
			$this->fieldFunctionAs_[$key_] = $as_;
			$this->$as_ = new xyo_datasource_EmptyField();
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
					"between"=>1,
					"not-between"=>2,
					"is-null"=>3,
					"is-not-null"=>4,
					"="=>5,
					"<"=>6,
					">"=>7,
					"<="=>8,
					">="=>9,
					"!="=>10,
					"like"=>11);
			if(array_key_exists($operator_,$opList)) {
				$this->fieldOperator_[$idx]=array(0=>0,1=>$key_,2=>$opList[$operator_],3=>$v1_,4=>$v2_,5=>$v1x_,6=>$v2x_);
				return true;
			};
		}
		return false;
	}

	function pushOperator($mode) {
		$opList1=array(
				 "and"=>1,
				 "or"=>2);

		$opList2=array(
				 "("=>3,
				 ")"=>4);

		if(array_key_exists($mode,$opList1)) {
			$idx=count($this->fieldOperator_);
			if($idx) {
				if(in_array($this->fieldOperator_[$idx-1][0],$opList1)) {
					$idx=$idx-1;
				}
			}
			$this->fieldOperator_[$idx]=array(0=>$opList1[$mode]);
			return true;
		} else if(array_key_exists($mode,$opList2)) {
			$idx=count($this->fieldOperator_);
			if($idx) {
				if(in_array($this->fieldOperator_[$idx-1][0],$opList2)) {
					if($this->fieldOperator_[$idx-1][0]==3&&$opList2[$mode]==4) {
						unset($this->fieldOperator_[$idx-1]);
						return true;
					};
				};
			};
			$this->fieldOperator_[$idx]=array(0=>$opList2[$mode]);
			return true;
		}
		return false;
	}


	function setIfNotEmpty($key_, $value_) {
		if ($this->isEmpty($value_)) {
			return;
		}
		$this->$key_ = $value_;
	}

	function update($what_=array()) {
		if(count($what_)) {
			if($this->load()) {
				for(; $this->isValid(); $this->loadNext()) {
					foreach ($what_ as $key_ => $value_) {
						$this->$key_=$value_;
					};
					$this->save();
				};
				return true;
			};
		};
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
		} else {
			$tablePrimaryKeyValue = null;
		};

		//--- this
		if ($tablePrimaryKeyValue) {

			return $this->updateRowX_();
		};

		return $this->insert();

	}

	function insert() {
		return $this->insertRow_();
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
			$retV = $this->deleteRow_();

			return $retV;
		};
		return false;
	}

	function load($start=null, $length=null) {

		if($this->primaryKey_) {
			if (is_null($this-> {$this->primaryKey_})) {
				if (($this->fieldType_[$this->primaryKey_] === "int")||
				    ($this->fieldType_[$this->primaryKey_] === "bigint")) {
					$this-> {$this->primaryKey_} = new xyo_datasource_EmptyField();
				};
			};
		};


		$this->resultLoadAll_ = false;
		$this->resultLimitStart_ = $start;
		$this->resultLimitLength_ = $length;

		$this->loadRecords_();
		$this->prepareResult_();

		$this->resultInLoadIndex_ = 0;
		$this->resultInLoadCount_ = $this->resultCount_;
		$this->resultInLoad_ = $this->resultRow_;
		if ($this->resultInLoadCount_) {

			if(empty($this->fieldSelect_)) {
				foreach ($this->fieldType_ as $key_ => $value_) {
					$this->$key_ = $this->resultInLoad_[$this->resultInLoadIndex_][$key_];
				};
			} else {
				$this->setEmptyValue();
				foreach ($this->fieldSelect_ as $key_) {
					$this->$key_ = $this->resultInLoad_[$this->resultInLoadIndex_][$key_];
				};
			};
			foreach ($this->fieldFunction_ as $k_ => $v_) {
				$this-> {$this->fieldFunctionAs_[$k_]} = $this->resultInLoad_[$this->resultInLoadIndex_][$this->fieldFunctionAs_[$k_]];
			};
			++$this->resultInLoadIndex_;
			return true;
		};
		$this->setEmptyValue();
		return false;
	}

	function tryLoad($start=null, $length=null) {

		if($this->primaryKey_) {
			if (is_null($this-> {$this->primaryKey_})) {
				if (($this->fieldType_[$this->primaryKey_] === "int")||
				    ($this->fieldType_[$this->primaryKey_] === "bigint")) {
					$this-> {$this->primaryKey_} = new xyo_datasource_EmptyField();
				};
			};
		};

		$this->resultLoadAll_ = false;
		$this->resultLimitStart_ = $start;
		$this->resultLimitLength_ = $length;

		$this->loadRecords_();
		$this->prepareResult_();

		$this->resultInLoadIndex_ = 0;
		$this->resultInLoadCount_ = $this->resultCount_;
		$this->resultInLoad_ = $this->resultRow_;
		if ($this->resultInLoadCount_) {
			if(empty($this->fieldSelect_)) {
				foreach ($this->fieldType_ as $key_ => $value_) {
					$this->$key_ = $this->resultInLoad_[$this->resultInLoadIndex_][$key_];
				};
			} else {
				$this->setEmptyValue();
				foreach ($this->fieldSelect_ as $key_) {
					$this->$key_ = $this->resultInLoad_[$this->resultInLoadIndex_][$key_];
				};
			};
			foreach ($this->fieldFunction_ as $k_ => $v_) {
				$this-> {$this->fieldFunctionAs_[$k_]} = $this->resultInLoad_[$this->resultInLoadIndex_][$this->fieldFunctionAs_[$k_]];
			};
			++$this->resultInLoadIndex_;
			return true;
		};
		return false;
	}

	function count() {
		$this->resultLoadAll_ = false;
		$this->loadRecords_();
		$this->prepareResult_();
		return $this->resultCount_;
	}

	function prepareFunction_($g_) {

		foreach ($this->fieldFunction_ as $fKey_ => $fValue_) {
			if ($fValue_ == "MAX") {
				$max_ = 0;
				$flag_ = true;
				foreach ($g_ as $g2vKey_) {
					if ($flag_) {
						$flag_ = false;

						$max_ = $this->resultRow_[$g2vKey_][$fKey_];
					} else {
						if ($max_ < $this->resultRow_[$g2vKey_][$fKey_]) {
							$max_ = $this->resultRow_[$g2vKey_][$fKey_];
						};
					};
				};
				foreach ($g_ as $g2vKey_) {
					$this->resultRow_[$g2vKey_][$this->fieldFunctionAs_[$fKey_]] = $max_;
				};
			} else if ($fValue_ == "MIN") {
				$min_ = 0;
				$flag_ = true;
				foreach ($g_ as $g2vKey_) {
					if ($flag_) {
						$flag_ = false;

						$min_ = $this->resultRow_[$g2vKey_][$fKey_];
					} else {
						if ($min_ > $this->resultRow_[$g2vKey_][$fKey_]) {
							$min_ = $this->resultRow_[$g2vKey_][$fKey_];
						};
					};
				};
				foreach ($g_ as $g2vKey_) {
					$this->resultRow_[$g2vKey_][$this->fieldFunctionAs_[$fKey_]] = $min_;
				};
			} else if ($fValue_ == "SUM") {
				$sum_ = 0;
				$flag_ = true;
				foreach ($g_ as $g2vKey_) {
					if ($flag_) {
						$flag_ = false;

						$sum_ = $this->resultRow_[$g2vKey_][$fKey_];
					} else {
						$sum_+=$this->resultRow_[$g2vKey_][$fKey_];
					};
				};
				foreach ($g_ as $g2vKey_) {
					$this->resultRow_[$g2vKey_][$this->fieldFunctionAs_[$fKey_]] = $sum_;
				};
			} else { // null
				foreach ($g_ as $g2vKey_) {
					$this->resultRow_[$g2vKey_][$this->fieldFunctionAs_[$fKey_]] = null;
				};
			};
		};
	}

	function prepareResult_() {
		if ($this->resultCount_) {

		} else {
			return;
		}
		//group by,order
		if (count($this->fieldGroup_)) {
			$group = array();
			foreach ($this->resultRow_ as $key_ => $value_) {
				$xKey = ":";
				foreach ($this->fieldGroup_ as $gKey_ => $gValue_) {
					$xKey.=$value_[$gKey_];
				};

				if (array_key_exists($xKey, $group)) {

				} else {
					$group[$xKey] = array();
				};

				$group[$xKey][] = $key_;
			};
			if (count($this->fieldFunction_)) {
				foreach ($group as $g_) {
					$this->prepareFunction_($g_);
				};
			};
			foreach ($group as $g_) {
				$flag = true;
				foreach ($g_ as $g2vKey_) {
					if ($flag) {
						$flag = false;
					} else {
						unset($this->resultRow_[$g2vKey_]);
					};
				};
			};
			$this->resultRow_ = array_values($this->resultRow_);
			$this->resultCount_ = count($this->resultRow_);
		} else {
			if (count($this->fieldFunction_)) {
				$g_ = array();
				for ($k = 0; $k < $this->resultCount_; ++$k) {
					$g_[] = $k;
				};
				$this->prepareFunction_($g_);
				$this->resultRow_ = array($this->resultRow_[0]);
				$this->resultCount_ = 1;
			};
		};
		if (count($this->fieldOrder_)) {
			for ($k = 0; $k < $this->resultCount_; ++$k) {
				$this->resultRow_[$k]["*"] = &$this->fieldOrder_;
			};
			uasort($this->resultRow_, "xyo_datasource_csv_table__cmp");
			$this->resultRow_ = array_values($this->resultRow_);
		};

		if (!is_null($this->resultLimitStart_)) {
			if (!is_null($this->resultLimitLength_)) {
				$this->resultRow_ = array_slice($this->resultRow_, $this->resultLimitStart_, $this->resultLimitLength_);
			} else {
				$this->resultRow_ = array_slice($this->resultRow_, $this->resultLimitStart_);
			};
			$this->resultCount_ = count($this->resultRow_);
		};
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
		if ($this->resultInLoadIndex_ < $this->resultInLoadCount_) {
			return true;
		}
		return false;
	}

	function loadNext() {
		if ($this->resultInLoadIndex_ < $this->resultInLoadCount_) {
			if(empty($this->fieldSelect_)) {
				foreach ($this->fieldType_ as $key_ => $value_) {
					$this->$key_ = $this->resultInLoad_[$this->resultInLoadIndex_][$key_];
				};
			} else {
				$this->setEmptyValue();
				foreach ($this->fieldSelect_ as $key_) {
					$this->$key_ = $this->resultInLoad_[$this->resultInLoadIndex_][$key_];
				};
			};
			foreach ($this->fieldFunction_ as $k_ => $v_) {
				$this-> {$this->fieldFunctionAs_[$k_]} = $this->resultInLoad_[$this->resultInLoadIndex_][$this->fieldFunctionAs_[$k_]];
			};
			++$this->resultInLoadIndex_;
			return true;
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

	function select($what=null) {
		$this->fieldSelect_=$what;
	}

	function clearNull_() {
		foreach ($this->fieldType_ as $key_ => $value_) {
			$this->$key_ = null;
		};
		$this->fieldGroup_ = array();
		$this->fieldOrder_ = array();
		$this->fieldFunction_ = array();
		$this->fieldFunctionAs_ = array();

		$this->fieldOperator_ = array();
	}

	function destroyStorage() {
		if (file_exists($this->fileName_)) {
			return unlink($this->fileName_);
		};
		return true;
	}

	function createStorage() {
		if (file_exists($this->fileName_)) {
			return true;
		}

		$this->resultPrimaryKeyIndex_ = 0;
		$this->resultCol_ = array();
		$this->resultRow_ = array();
		$this->resultPrimaryKeyIndex_ = 0;
		return $this->writeDataSource_();
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

	function updateRowX_() {
		$this->resultLoadAll_ = true;
		$this->resultLimitStart_ = null;
		$this->resultLimitEnd_ = null;

		if($this->primaryKey_) {} else {
			return false;
		};

		if ($this->isEmpty($this-> {$this->primaryKey_}))
			return false;
		if (is_null($this-> {$this->primaryKey_}))
			return false;

		//load all records

		$this->loadRecords_();

		if (is_array($this-> {$this->primaryKey_})) {
			foreach ($this-> {$this->primaryKey_} as $key_) {
				foreach ($this->resultRow_ as $key2_ => $value2_) {
					if ($value2_[$this->primaryKey_] == $key_) {

						foreach ($this->fieldType_ as $key_ => $value_) {
							if ($this->isEmpty($this->$key_)) {
								continue;
							}
							$this->resultRow_[$key2_][$key_] = $this->$key_;
						};
					};
				};
			};
		}
		else {

			foreach ($this->resultRow_ as $key2_ => $value2_) {
				if ($value2_[$this->primaryKey_] == $this-> {$this->primaryKey_}) {

					foreach ($this->fieldType_ as $key_ => $value_) {
						if ($this->isEmpty($this->$key_)) {
							continue;
						}
						$this->resultRow_[$key2_][$key_] = $this->$key_;
					};
				};
			};
		};

		return $this->writeDataSource_();
	}

	function insertRow_() {
		$this->resultLoadAll_ = true;
		$this->resultLimitStart_ = null;
		$this->resultLimitLength_ = null;

		//load all records
		$this->loadRecords_();

		if($this->primaryKey_) {
			if ($this->isEmpty($this-> {$this->primaryKey_})) {
				if ($this->fieldDefaultValue_[$this->primaryKey_] == "DEFAULT") {
					++$this->resultPrimaryKeyIndex_;
					$this-> {$this->primaryKey_} = $this->resultPrimaryKeyIndex_;
				};
			}
			else {
				if($this->primaryKey_===$this->fieldAutoIncrement_) {
					if($this-> {$this->primaryKey_}>$this->resultPrimaryKeyIndex_) {
						$this->resultPrimaryKeyIndex_=$this-> {$this->primaryKey_};
					};
				};
			};
		};

		$data = array();
		foreach ($this->resultCol_ as $key_) {
			if (array_key_exists($key_, $this->fieldType_)) {
				$data[$key_] = $this->$key_;
			};
		};


		$this->resultRow_[] = $data;

		return $this->writeDataSource_();
	}

	function deleteRow_() {
		$this->resultLoadAll_ = true;
		$this->resultLimitStart_ = null;
		$this->resultLimitLength_ = null;

		//load all records
		$this->loadRecords_();

		$newRow_ = array();

		foreach ($this->resultRow_ as $key_ => $value_) {
			if ($this->checkRow_($value_)) {
				$this->resultRow_[$key_] = null;
			};
		};


		return $this->writeDataSource_();
	}

	function checkRow_($row) {
		$retV = true;


		foreach ($this->fieldType_ as $key_ => $value_) {
			if ($this->isEmpty($this->$key_)) {
				continue;
			};

			if (is_array($this->$key_)) {
				$found_ = false;
				foreach ($this->$key_ as $v_) {
					if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
						if (strcasecmp($v_,$row[$key_])==0) {
							$found_ = true;
							break;
						};
					}else{
						if ($v_ == $row[$key_]) {
							$found_ = true;
							break;
						};
					};
				};
				if ($found_) {

				} else {
					$retV = false;
				};

				if ($retV) {

				} else {
					break;
				}
			} else {
				if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
					if (strcasecmp($this->$key_ , $row[$key_])!=0) {
						$retV = false;
						break;
					};
				}else{
					if ($this->$key_ != $row[$key_]) {
						$retV = false;
						break;
					};
				};
			};
		};

		if(count($this->fieldOperator_)) {
			$opSp=array(array(0=>0,1=>$retV));
			foreach($this->fieldOperator_ as $key_ => $value_) {
				$bRet=false;
				if($value_[0]==0) {
				} else {
					$opSp[]=array(0=>$value_[0]);
					continue;
				};

				$key_=$value_[1];
				if($value_[2]==1) {
					if($value_[5]) {
						$v1=$row[$value_[3]];
					} else {
						$v1=$value_[3];
					};
					if($value_[6]) {
						$v2=$row[$value_[4]];
					} else {
						$v2=$value_[4];
					};

					$val_=$row[$key_];
					if($this->fieldType_[$key_]=="date") {
						$val_=strtotime($val_." 12:00:00");
						$v1=strtotime($v1." 00:00:00");
						$v2=strtotime($v2." 23:59:59");
					};
					if($this->fieldType_[$key_]=="datetime") {
						$val_=strtotime($val);
						$v1=strtotime($v1);
						$v2=strtotime($v2);
					};

					if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
						if((strcasecmp($val_,$v1)>=0)&&(strcasecmp($val_,$v2)<=0)) {
							$bRet=true;
						};
					}else{
						if(($val_ >=$v1)&&($val_ <=$v2)) {
							$bRet=true;
						};
					};

				} else if($value_[2]==2) {
					if($value_[5]) {
						$v1=$row[$value_[3]];
					} else {
						$v1=$value_[3];
					};
					if($value_[6]) {
						$v2=$row[$value_[4]];
					} else {
						$v2=$value_[4];
					};
					$val_=$row[$key_];
					if($this->fieldType_[$key_]=="date") {
						$val_=strtotime($val_." 12:00:00");
						$v1=strtotime($v1." 00:00:00");
						$v2=strtotime($v2." 23:59:59");
					};
					if($this->fieldType_[$key_]=="datetime") {
						$val_=strtotime($val);
						$v1=strtotime($v1);
						$v2=strtotime($v2);
					};

					if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
						if((strcasecmp($val_,$v1)>=0)&&(strcasecmp($val_,$v2)<=0)) {
						}else{
							$bRet=true;		
						};
					}else{
						if(($val_ >=$v1)&&($val_ <=$v2)) {
						} else {
							$bRet=true;
						};
					};
				} else if($value_[2]==3) {
					if(is_null($row[$key_])) {
						$bRet=true;
					};
				} else if($value_[2]==4) {
					if(is_null($row[$key_])) {
					} else {
						$bRet=true;
					};
				} else if($value_[2]==5) {
					$chk=$row[$key_];
					$flag=true;
					if($this->isEmpty($chk)||is_null($chk)) {
						if($value_[6]) {
							$chk=$value_[4];
						} else {
							$flag=false;
						};
					};
					if($flag) {
						if($value_[5]) {
							$v1=$row[$value_[3]];
						} else {
							$v1=$value_[3];
						};

						if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
							if(strcasecmp($chk,$v1)==0) {
								$bRet=true;
							};
						}else{
							if($chk==$v1) {
								$bRet=true;
							};
						};
					};
				} else if($value_[2]==6) {
					$chk=$row[$key_];
					$flag=true;
					if($this->isEmpty($chk)||is_null($chk)) {
						if($value_[6]) {
							$chk=$value_[4];
						} else {
							$flag=false;
						};
					};
					if($flag) {
						if($value_[5]) {
							$v1=$row[$value_[3]];
						} else {
							$v1=$value_[3];
						};

						if($this->fieldType_[$key_]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldType_[$key_]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
							if(strcasecmp($chk,$v1)<0) {
								$bRet=true;
							};
						}else{
							if($chk<$v1) {
								$bRet=true;
							};
						};
					};
				} else if($value_[2]==7) {
					$chk=$row[$key_];
					$flag=true;
					if($this->isEmpty($chk)||is_null($chk)) {
						if($value_[6]) {
							$chk=$value_[4];
						} else {
							$flag=false;
						};
					};
					if($flag) {
						if($value_[5]) {
							$v1=$row[$value_[3]];
						} else {
							$v1=$value_[3];
						};

						if($this->fieldType_[$key_]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldType_[$key_]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
							if(strcasecmp($chk,$v1)>0) {
								$bRet=true;
							};
						}else{
							if($chk>$v1) {
								$bRet=true;
							};
						};
					};
				} else if($value_[2]==8) {
					$chk=$row[$key_];
					$flag=true;
					if($this->isEmpty($chk)||is_null($chk)) {
						if($value_[6]) {
							$chk=$value_[4];
						} else {
							$flag=false;
						};
					};
					if($flag) {
						if($value_[5]) {
							$v1=$row[$value_[3]];
						} else {
							$v1=$value_[3];
						};

						if($this->fieldType_[$key_]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldType_[$key_]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
							if(strcasecmp($chk,$v1)<=0) {
								$bRet=true;
							};
						}else{
							if($chk<=$v1) {
								$bRet=true;
							};
						};
					};
				} else if($value_[2]==9) {
					$chk=$row[$key_];
					$flag=true;
					if($this->isEmpty($chk)||is_null($chk)) {
						if($value_[6]) {
							$chk=$value_[4];
						} else {
							$flag=false;
						};
					};
					if($flag) {
						if($value_[5]) {
							$v1=$row[$value_[3]];
						} else {
							$v1=$value_[3];
						};

						if($this->fieldType_[$key_]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldType_[$key_]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
							if(strcasecmp($chk,$v1)>=0) {
								$bRet=true;
							};
						}else{
							if($chk>=$v1) {
								$bRet=true;
							};
						};
					};
				} else if($value_[2]==10) {
					$chk=$row[$key_];
					$flag=true;
					if($this->isEmpty($chk)||is_null($chk)) {
						if($value_[6]) {
							$chk=$value_[4];
						} else {
							$flag=false;
						};
					};
					if($flag) {
						if($value_[5]) {
							$v1=$row[$value_[3]];
						} else {
							$v1=$value_[3];
						};

						if(($this->fieldType_[$key_]=="text") || ($this->fieldType_[$key_]=="varchar")){
							if(strcasecmp($chk,$v1)!=0) {
								$bRet=true;
							};
						}else{
							if($chk!=$v1) {
								$bRet=true;
							};
						};
					};
				} else if($value_[2]==11) {
					if($value_[5]) {
						$v1=$row[$value_[3]];
					} else {
						$v1=$value_[3];
					};
					if($this->isEmpty($row[$key_])||is_null($row[$key_])) {
					} else {
						if(stristr($row[$key_],$v1)===false) {
						} else {
							$bRet=true;
						};
					};
				};


				$opSp[]=array(0=>0,1=>$bRet);
			};

			$opSpOp=array();
			$opSpOut=array();
			foreach ($opSp as $key=>$value) {
				if($value[0]==0) {
					$opSpOut[]=$value;
				} else if($value[0]==3) {
					$opSpOp[]=$value;
				} else if($value[0]==4) {
					if(count($opSpOp)) {
						$op=array_pop($opSpOp);
						while($op[0]!=3) {
							$opSpOut[]=$op;
							if(count($opSpOp)) {
								$op=array_pop($opSpOp);
							} else {
								break;
							}
						}
					}
				} else {
					if(count($opSpOp)) {
						$op=array_pop($opSpOp);
						if(($op[0]==1)||($op[0]==2)) {
							$opSpOut[]=$op;
						} else {
							$opSpOp[]=$op;
						}
					}
					$opSpOp[]=$value;
				}
			}
			while(count($opSpOp)) {
				$opSpOut[]=array_pop($opSpOp);
			}

			$opSp=array();
			foreach($opSpOut as $key=>$value) {
				if($value[0]==0) {
					$opSp[]=$value[1];
				} else if($value[0]==1) {
					$v2=array_pop($opSp);
					$v1=array_pop($opSp);
					$opSp[]= $v1 && $v2;
				} else if($value[0]==2) {
					$v2=array_pop($opSp);
					$v1=array_pop($opSp);
					$opSp[]= $v1 || $v2;
				}
			}

			$retV=array_pop($opSp);

		}

		return $retV;
	}

	function setCol($col) {
		$this->resultCol_ = $col;
		$this->resultCount_ = 0;
		$this->resultRow_ = array();
		return false; // next record
	}

	function setPrimaryKeyIndex($value) {
		$this->resultPrimaryKeyIndex_ = $value;
		return false;
	}

	function setRow($row) {
		$data = array();
		$k = 0;
		foreach ($this->resultCol_ as $key_) {
			$data[$key_] = $row[$k];
			++$k;
		};

		if ($this->resultLoadAll_) {
			$this->resultRow_[] = $data;
			++$this->resultCount_;
		} else {
			if ($this->checkRow_($data)) {
				$this->resultRow_[] = $data;
				++$this->resultCount_;
			};
		};
		return false;
	}

	function loadRecords_() {
		if (file_exists($this->fileName_)) {
			$fp = fopen($this->fileName_, 'r');
			if ($fp) {
				$first = true;
				while ($row = fgetcsv($fp, 16384, ',', '"')) {
					if (count($row) == 1) {
						if (is_null($row[0])) {
							continue;
						}
					};
					if ($first) {
						$first = false;
						if ($this->primaryKey_) {
							for ($k = 0; $k < count($row); ++$k) {
								$x_ = explode(":", $row[$k]);
								if (count($x_) == 2) {
									if ($x_[0] === $this->primaryKey_) {
										$this->setPrimaryKeyIndex($x_[1]);
										$row[$k] = $x_[0];
										break;
									};
								};
							};
						};
						$this->setCol($row);
					} else {
						$this->setRow($row);
					}
				};
				fclose($fp);
				return true;
			};
		};
		return false;
	}

	function writeDataSource_() {
		$file_ = fopen($this->fileName_, "w");
		if ($file_) {
			$this->writeBegin_($file_);
			$this->writeLastModified_($file_);
			$this->writeCol_($file_);
			$this->writePrimaryKeyIndex_($file_);
			$this->writeRows_($file_);
			$this->writeEnd_($file_);
			fclose($file_);
			return true;
		};
		return false;
	}

	function writeBegin_($file_) {

	}

	function writeLastModified_($file_) {

	}

	function writeEnd_($file_) {

	}

	function writePrimaryKeyIndex_($file_) {

	}

	function writeCol_($file_) {
		if (count($this->resultCol_) > 0) {

		} else {
			$this->resultCol_ = array();
			foreach ($this->fieldType_ as $key_ => $value_) {
				$this->resultCol_[] = $key_;
			};
		};

		$x_ = array();
		foreach ($this->resultCol_ as $value_) {
			if($this->primaryKey_) {
				if ($value_ === $this->primaryKey_) {
					$x_[] = $value_ . ":" . $this->resultPrimaryKeyIndex_;
				} else {
					$x_[] = $value_;
				}
			} else {
				$x_[] = $value_;
			};
		}

		fputcsv($file_, $x_, ',', '"');
	}

	function writeRows_($file_) {

		foreach ($this->resultRow_ as $value_) {

			if (is_null($value_)) {
				continue;
			}
			foreach ($this->resultCol_ as $key_) {
				if (array_key_exists($key_, $this->fieldType_)) {
					if ($this->isEmpty($value_[$key_])) {
						$value_[$key_] = $this->getRowValueSourceCode_($this->fieldType_[$key_], $this->fieldDefaultValue_[$key_]);
					} else {
						$value_[$key_] = $this->getRowValueSourceCode_($this->fieldType_[$key_], $value_[$key_]);
					}
				};
			};

			fputcsv($file_, $value_, ',', '"');
		};
	}

	function setLastModified($x) {
		return false;
	}

	function getDateNow_() {
		return date("Y-m-d");
	}

	function getDateTimeNow_() {
		return date("Y-m-d H:i:s");
	}

	function getTimeNow_() {
		return date("H:i:s");
	}

	function getRowValueSourceCode_($type_, $value_) {
		if ($type_ == "int") {
			if (strcmp($value_, "DEFAULT") == 0) {
				return "0";
			}
			return (1 * $value_);
		} else if ($type_ == "bigint") {
			if (strcmp($value_, "DEFAULT") == 0) {
				return "0";
			}
			return (1 * $value_);
		} else if ($type_ == "float") {
			if (strcmp($value_, "DEFAULT") == 0) {
				return "0";
			}
			return (1 * $value_);
		} else if ($type_ == "text") {
			if (is_null($value_)) {
				return null;
			};
			return $value_;
		} else if ($type_ == "varchar") {
			if (is_null($value_)) {
				return null;
			};
			return $value_;
		} else if ($type_ == "date") {
			if (is_null($value_)) {
				return null;
			};
			if ($value_ == "NOW") {
				return $this->getDateNow_();
			};
			return $value_;
		} else if ($type_ == "time") {
			if (is_null($value_)) {
				return null;
			};
			if ($value_ == "NOW") {
				return $this->getTimeNow_();
			};
			return $value_;
		} else if ($type_ == "datetime") {
			if (is_null($value_)) {
				return null;
			};
			if ($value_ == "NOW") {
				return $this->getDateTimeNow_();
			};
			return $value_;
		};
		return null;
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
		$this->realName_ = $name;
		$this->storageHint_=$this->realName_;
		$this->fileName_ = $this->connection_->databasePath . $this->realName_ . ".php";
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
		$ds = &$this->copyThis();
		$ds->clear();
		$ds->{$this->primaryKey_}=$this->{$this->primaryKey_};
		if($ds->load(0,1)){
			$ds->{$field} = $ds->{$field} + $value;
			return $ds->save();
		};
		return false;
	}

	function atomicIncrement($field){
		return $this->atomicAdd($field,1);
	}

	function atomicSub($field,$value) {
		$ds = &$this->copyThis();
		$ds->clear();
		$ds->{$this->primaryKey_}=$this->{$this->primaryKey_};
		if($ds->load(0,1)){
			$ds->{$field} = $ds->{$field} - $value;
			return $ds->save();
		};
		return false;
	}

	function atomicDecrement($field){
		return $this->atomicSub($field,1);
	}

	function storageRemoveField($name) {
		return false;		
	}

	function storageRenameField($oldName, $newName) {
		return false;		
	}

	function storageUpdateField($name) {		
		return true;
	}

}

