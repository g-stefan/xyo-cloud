<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_datasource_csv_Query extends xyo_Config {

	var $module_;
	var $connection_;
	var $name_;
	var $datasource_;	
	var $descriptor_;
	//---
	var $queryTable_;
	var $queryField_;
	var $queryKey_;
	var $queryKeyIsKey_;
	var $queryFirstTable_;
	var $queryFirstKey_;
	var $querySecondTable_;
	var $querySecondKey_;
	var $queryMode_;
	var $querySave_;
	var $queryDelete_;
	var $querySetOrder_;
	var $isOk_;
	//----
	var $result_;
	var $fieldGroup_;
	var $fieldOrder_;
	var $fieldTable_;
	var $orderNone;
	var $orderAscendent;
	var $orderDescendent;
	var $fieldFunction_;
	var $fieldFunctionAs_;

	var $fieldOperator_;

	var $primaryTable_;
	//----
	var $resultRow_;
	var $resultCount_;
	var $resultLimitStart_;
	var $resultLimitLength_;
	var $resultLoadAll_;
	var $resultPrimaryKeyIndex_;
	var $resultInLoadIndex_;
	var $resultInLoadCount_;
	var $resultInLoad_;
	//-----

	var $fieldSelect_;


	function __construct(&$module, &$connection, $name, $datasource, $descriptor, $doInit=true) {
		parent::__construct($module->getCloud());

		$this->module_ = &$module;
		$this->connection_ = &$connection;
		$this->name_ = $name;
		$this->datasource_ = $datasource;		
		$this->descriptor_=$descriptor;


		$this->resultTable_ = array();
		$this->resultRow_ = array();
		$this->resultCount_ = 0;

		$this->isOk_ = false;

		if ($doInit) {
			$this->isOk_ = false;$this->includeFile($this->descriptor_);

			$this->queryTable_ = $this->get("query_table", array());
			$this->queryField_ = $this->get("query_field", array());
			$this->queryKey_ = $this->get("query_key", array());
			$this->queryKeyIsKey_ = $this->get("query_key_is_key", array());
			$this->queryFirstTable_ = $this->get("query_first_table", array());
			$this->queryFirstKey_ = $this->get("query_first_key", array());
			$this->querySecondTable_ = $this->get("query_second_table", array());

			$this->querySecondKey_ = $this->get("query_second_key", array());
			$this->queryMode_ = $this->get("query_mode", array());

			$this->querySave_ = $this->get("query_save", array());
			$this->queryDelete_ = $this->get("query_delete", array());

			$this->querySetOrder_ = $this->get("query_set_order", array());

			//post-process
			$item = $this->get("query_item", array());
			foreach ($item as $k => $v) {
				foreach ($v as $kv => $vv) {
					$this->queryField_[$k] = $kv;
					$this->queryKey_[$k] = $vv;
				}
			}

			$link = $this->get("query_link", array());
			foreach ($link as $k => $v) {
				if (is_array($v)) {
					$count = 0;
					foreach ($v as $kx => $vx) {
						if ($count == 0) {
							$this->queryMode_[$k] = $vx;
						} else if ($count == 1) {
							foreach ($vx as $kvx => $vvx) {
								$this->queryFirstTable_[$k] = $kvx;
								$this->queryFirstKey_[$k] = $vvx;
							}
						} else if ($count == 2) {
							foreach ($vx as $kvx => $vvx) {
								$this->querySecondTable_[$k] = $kvx;
								$this->querySecondKey_[$k] = $vvx;
							}
						}
						++$count;
					}
				} else {
					$this->queryMode_[$k] = $v;
				}
			}
		};
		//----

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

			$this->fieldSelect_=null;

			$ok = true;
			foreach ($this->queryField_ as $key_ => $value_) {
				if (array_key_exists($key_, $this->queryKey_)) {
					continue;
				}
				$ok = false;
				break;
			};

			if ($ok) {

			} else {

				trigger_error(
					'In query definition `' . $this->name_ .
					'` every queryField[x] must have queryKey[x] '
					, E_USER_ERROR);
			};


			$this->fieldTable_ = array();

			foreach ($this->queryTable_ as $key_ => $value_) {
				$this->fieldTable_[$key_] = &$this->module_->ds->getDataSource($value_);
				if (!$this->fieldTable_[$key_]) {
					trigger_error(
						'In query definition `' . $this->name_ .
						'` queryTable: ' . $value_ . ' not found '
						, E_USER_ERROR);
				}
			};

			foreach ($this->queryField_ as $key_ => $value_) {
				$this->$key_ = $this->fieldTable_[$value_]-> {$this->queryKey_[$key_]};
			};


			$this->primaryTable_ = null;
			foreach ($this->queryMode_ as $key_ => $value_) {
				if ($value_ === "base") {
					$this->primaryTable_ = $key_;
					break;
				};
			};

			if ($this->primaryTable_) {

			} else {
				trigger_error(
					'In query definition `' . $this->name_ .
					'` in query.mode base not defined  '
					, E_USER_ERROR);
			};
		};
	}

	function isOk() {
		return $this->isOk_;
	}

	function isEmpty(&$value) {
		return ($value instanceof xyo_datasource_EmptyField);
	}

	function getType() {
		return "query";
	}

	function getFieldList() {
		return array_keys($this->queryField_);
	}

	function transferTo(&$object) {
		foreach ($this->queryField_ as $key_ => $value_) {
			if ($this->isEmpty($this->$key_)) {

			} else {
				$object->$key_ = $this->$key_;
			};
		};
	}

	function &copyThis() {
		$retV = new xyo_datasource_csv_Query($this->module_, $this->connection_, $this->name_, $this->datasource_, $this->descriptor_, false);
		if ($retV) {
		
			$retV->isOk_ = $this->isOk_;
			$retV->queryTable_ = &$this->queryTable_;
			$retV->queryField_ = &$this->queryField_;
			$retV->queryKey_ = &$this->queryKey_;
			$retV->queryKeyIsKey_ = &$this->queryKeyIsKey_;
			$retV->queryFirstTable_ = &$this->queryFirstTable_;
			$retV->queryFirstKey_ = &$this->queryFirstKey_;
			$retV->querySecondTable_ = &$this->querySecondTable_;

			$retV->querySecondKey_ = &$this->querySecondKey_;
			$retV->queryMode_ = &$this->queryMode_;

			$retV->querySave_ = &$this->querySave_;
			$retV->queryDelete_ = &$this->queryDelete_;

			$retV->querySetOrder_ = &$this->querySetOrder_;

			$retV->fieldGroup_ = $this->fieldGroup_;
			$retV->fieldOrder_ = $this->fieldOrder_;


			$retV->fieldFunction_ = $this->fieldFunction_;
			$retV->fieldFunctionAs_ = $this->fieldFunctionAs_;

			$retV->querySetOrder_ = &$this->querySetOrder_;

			$retV->fieldTable_ = array();

			$retV->primaryTable_ = $this->primaryTable_;

			$retV->fieldSelect_=$this->fieldSelect_;

			foreach ($retV->queryTable_ as $key_ => $value_) {
				$retV->fieldTable_[$key_] = &$this->fieldTable_[$key_]->copyThis();
			};

			foreach ($this->queryField_ as $key_ => $value_) {
				$retV->$key_ = $this->$key_;
			};
		};
		return $retV;
	}

	function has($name) {
		return $this->hasValue($name);
	}

	function hasValue($name) {
		if (array_key_exists($name, $this->queryField_)) {
			return true;
		};

		return false;
	}

	function setOrder($key_, $value_) {
		if (array_key_exists($key_, $this->queryField_)) {
			if ($value_ != $this->orderNone) {
				$this->fieldOrder_[$key_] = $value_;
			} else {
				unset($this->fieldOrder_[$key_]);
			};
			return;
		}
	}

	function setGroup($key_, $value_) {
		if (array_key_exists($key_, $this->queryField_)) {
			if ($value_) {
				$this->fieldGroup_[$key_] = $value_;
			} else {
				unset($this->fieldGroup_[$key_]);
			};
			return;
		}
	}

	function setFunctionAs($key_, $function_, $as_) {
		if (array_key_exists($key_, $this->queryField_)) {
			$this->fieldFunction_[$key_] = $function_;
			$this->fieldFunctionAs_[$key_] = $as_;
		}
	}

	function setOperator($key_,$operator_, $v1_=null, $v2_=null,$v1x_=false,$v2x_=false) {
		if (array_key_exists($key_, $this->queryField_)) {
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


	function getQueryValue($key_, $value_) {
		return $this->connection_->safeTypeValue($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]], $value_);
	}

	function getDefaultEmptyValue($key_) {
		if (($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]] == "int")||
		    ($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]] == "bigint")) {
			return 0;
		} else {
			return null;
		}
	}

	function getDefaultValue($key_) {
		return $this->fieldTable_[$this->queryField_[$key_]]->getDefaultValue($this->queryKey_[$key_]);
	}

	function loadRecords_() {

		foreach ($this->queryMode_ as $key_ => $value_) {
			$this->resultTable_[$key_] = &$this->fieldTable_[$key_]->copyThis();
			$this->resultTable_[$key_]->clear();
		};

		$this->processLoadQuery(0);
	}

	function processLoadQuery($level_) {
		$key_ = null;
		$scan_ = array_keys($this->queryMode_);
		for ($k = 0; $k < count($scan_); ++$k) {
			if ($k == $level_) {
				$key_ = $scan_[$k];
				break;
			};
		};
		if ($key_) {

		} else {
			$this->processLoadQueryLevel2();
			return;
		};

		$this->resultTable_[$key_]->clear();
		foreach ($this->queryField_ as $key2_ => $value2_) {
			if ($value2_ === $key_) {
				$this->resultTable_[$key_]-> {$this->queryKey_[$key2_]} = $this->$key2_;
			};
		};


		if ($this->queryMode_[$key_] === "base") {

		} else if ($this->queryMode_[$key_] === "outer") {


			if ($this->isEmpty($this->resultTable_[$this->querySecondTable_[$key_]]-> {$this->querySecondKey_[$key_]})) {
				$this->resultTable_[$key_]->clearNull_();
				$this->processLoadQuery($level_ + 1);
				return;
			}
			else {

				$this->resultTable_[$key_]-> {$this->queryFirstKey_[$key_]} = $this->resultTable_[$this->querySecondTable_[$key_]]-> {$this->querySecondKey_[$key_]};

				if ($this->resultTable_[$key_]->tryLoad()) {
					for (; $this->resultTable_[$key_]->isValid(); $this->resultTable_[$key_]->loadNext()) {
						$this->processLoadQuery($level_ + 1);
					};
					return;
				} else {
					$this->resultTable_[$key_]->clear();
					$this->processLoadQuery($level_ + 1);
					return;
				};
			};
		};

		for ($this->resultTable_[$key_]->load(); $this->resultTable_[$key_]->isValid(); $this->resultTable_[$key_]->loadNext()) {
			$this->processLoadQuery($level_ + 1);
		};
	}

	function processLoadQueryLevel2() {
		$row = array();

		foreach ($this->queryField_ as $key_ => $value_) {
			$row[$key_] = $this->resultTable_[$value_]-> {$this->queryKey_[$key_]};
		};

		foreach ($this->queryMode_ as $key_ => $value_) {
			if ($value_ === "link") {
				if ($this->resultTable_[$this->queryFirstTable_[$key_]]-> {$this->queryFirstKey_[$key_]} ===
					    $this->resultTable_[$this->querySecondTable_[$key_]]-> {$this->querySecondKey_[$key_]}) {

				} else {
					return;
				};
			};
		};

		$row = array();
		foreach ($this->queryField_ as $key_ => $value_) {
			$row[$key_] = $this->resultTable_[$value_]-> {$this->queryKey_[$key_]};
		};
		$this->setRow($row);
	}

	function setRow($row) {
		if ($this->resultLoadAll_) {
			$this->resultRow_[] = $row;
			foreach ($this->queryField_ as $key_ => $value_) {
				if ($this->isEmpty($row[$key_])) {
					$row[$key_] = $this->fieldTable_[$value_]->fieldDefaultValue_[$this->queryKey_[$key_]];
				}
			};
			++$this->resultCount_;
		} else {
			if ($this->checkRow_($row)) {
				foreach ($this->queryField_ as $key_ => $value_) {
					if ($this->isEmpty($row[$key_])) {
						$row[$key_] = $this->fieldTable_[$value_]->fieldDefaultValue_[$this->queryKey_[$key_]];
					}
				};
				$this->resultRow_[] = $row;
				++$this->resultCount_;
			};
		};

		return false;
	}

	function querySetOrderLoad_() {
		$x_ = $this->querySetOrder_;
		foreach ($x_ as $key_ => $value_) {

			if (array_key_exists($key_, $this->querySecondTable_)) {

				if ($this->fieldTable_[$this->queryFirstTable_[$key_]]->hasValue($this->queryFirstKey_[$key_])) {

					$this->fieldTable_[$this->querySecondTable_[$key_]]->setIfNotEmpty($this->querySecondKey_[$key_], $this->fieldTable_[$this->queryFirstTable_[$key_]]-> {$this->queryFirstKey_[$key_]});
				};
			} else if (is_array($value_)) {
				foreach ($value_ as $value__) {
					if (array_key_exists($value__, $this->querySecondTable_)) {
						if ($this->fieldTable_[$this->querySecondTable_[$value__]]->hasValue($this->querySecondKey_[$value__])) {
							$this->fieldTable_[$this->queryFirstTable_[$value__]]->setIfNotEmpty($this->queryFirstKey_[$value__], $this->fieldTable_[$this->querySecondTable_[$value__]]-> {$this->querySecondKey_[$value__]});
						};
					};
				};
			} else if (array_key_exists($value_, $this->querySecondTable_)) {

				if ($this->fieldTable_[$this->querySecondTable_[$value_]]->hasValue($this->querySecondKey_[$value_])) {

					$this->fieldTable_[$this->queryFirstTable_[$value_]]->setIfNotEmpty($this->queryFirstKey_[$value_], $this->fieldTable_[$this->querySecondTable_[$value_]]-> {$this->querySecondKey_[$value_]});
				};
			};
		};
	}

	function queryTableSet_() {

		foreach ($this->queryTable_ as $key_ => $value_) {
			$this->fieldTable_[$key_]->clear();
		};

		if (count($this->queryKeyIsKey_)) {

			foreach ($this->queryKeyIsKey_ as $key_ => $value_) {
				$this->fieldTable_[$this->queryField_[$key_]]-> {$this->queryKey_[$key_]} = $this->$key_;
			};
		} else {

			foreach ($this->queryField_ as $key_ => $value_) {
				$this->fieldTable_[$this->queryField_[$key_]]-> {$this->queryKey_[$key_]} = $this->$key_;
			};
		};


		$primaryKey_ = $this->fieldTable_[$this->primaryTable_]->primaryKey_;
		if($primaryKey_) {
			$isEmptyPrimaryKey_ = $this->isEmpty($this->fieldTable_[$this->primaryTable_]-> {$primaryKey_});
		} else {
			$isEmptyPrimaryKey_ = true;
		};

		foreach ($this->querySetOrder_ as $key_ => $value_) {

			if ($isEmptyPrimaryKey_) {
				if ($this->primaryTable_ === $key_) {
					continue;
				};

				if ($this->querySecondTable_[$key_] === $this->primaryTable_) {
					if($primaryKey_) {
						if ($this->querySecondKey_[$key_] === $primaryKey_) {
							continue;
						};
					};
				};
			};

			$this->querySetOrderLoad_();

			if ($key_ === $this->primaryTable_) {

			} else {
				if ($this->fieldTable_[$key_]->isValid()) {
					if ($this->fieldTable_[$key_]->tryLoad()) {
						foreach ($this->queryField_ as $key2_ => $value2_) {
							if ($key_ == $value2_) {
								$this-> {$key2_} = $this->fieldTable_[$key_]-> {$this->queryKey_[$key2_]};
							};
						};
					};
				};
			};
		};

		foreach ($this->queryField_ as $key_ => $value_) {
			$this->fieldTable_[$this->queryField_[$key_]]-> {$this->queryKey_[$key_]} = $this->$key_;
		};
		$this->querySetOrderLoad_();
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
		if (count($this->querySave_) == 0) {
			return true;
		}

		$oldV = array();
		foreach ($this->queryField_ as $keyX_ => $valueX_) {
			$oldV[$keyX_] = $this->$keyX_;
		};

		$this->queryTableSet_();


		foreach ($this->queryField_ as $keyX_ => $valueX_) {
			if ($this->isEmpty($oldV[$keyX_])) {

			} else {
				$this->fieldTable_[$this->queryField_[$keyX_]]-> {$this->queryKey_[$keyX_]} = $oldV[$keyX_];
				$this->$keyX_ = $oldV[$keyX_];
			}
		};

		$ok = true;
		foreach ($this->querySave_ as $key_ => $value_) {

			if(is_bool($value_)){
				if(!$value_){
					continue;
				};
			};
			if(is_string($value_)){
				if($value_=="key"){

					$this->fieldTable_[$key_]->clear();
                                        $this->querySetOrderLoad_();
					$this->fieldTable_[$key_]->tryLoad(0,1);
					foreach ($this->queryField_ as $keyF_ => $valueF_) {
						if($valueF_==$key_) {
							$this->fieldTable_[$valueF_]-> {$this->queryKey_[$keyF_]} = $this->{$keyF_};
						};
					};

				};
			};

			if ($this->fieldTable_[$key_]->save()) {
				$this->querySetOrderLoad_();

				foreach ($this->queryField_ as $key2_ => $value2_) {
					if ($value2_ == $key_) {
						$this->$key2_ = $this->fieldTable_[$key_]-> {$this->queryKey_[$key2_]};
					};
				};
			} else {
				$ok = false;
				break;
			};
		};

		return $ok;
	}

	function insert() {
		if (count($this->querySave_) == 0) {
			return true;
		}

		$oldV = array();
		foreach ($this->queryField_ as $keyX_ => $valueX_) {
			$oldV[$keyX_] = $this->$keyX_;
		};

		$this->queryTableSet_();


		foreach ($this->queryField_ as $keyX_ => $valueX_) {
			if ($this->isEmpty($oldV[$keyX_])) {

			} else {
				$this->fieldTable_[$this->queryField_[$keyX_]]-> {$this->queryKey_[$keyX_]} = $oldV[$keyX_];
				$this->$keyX_ = $oldV[$keyX_];
			}
		};

		$ok = true;
		foreach ($this->querySave_ as $key_ => $value_) {
			if ($this->fieldTable_[$key_]->insert()) {
				$this->querySetOrderLoad_();

				foreach ($this->queryField_ as $key2_ => $value2_) {
					if ($value2_ == $key_) {
						$this->$key2_ = $this->fieldTable_[$key_]-> {$this->queryKey_[$key2_]};
					};
				};
			} else {
				$ok = false;
				break;
			};
		};

		return $ok;
	}

	function isOkToDelete() {

		if (count($this->queryDelete_) == 0) {
			return false;
		}

		$this->queryTableSet_();

		return true;
	}

	function delete() {
		if ($this->isOkToDelete()) {

			foreach ($this->queryDelete_ as $key_ => $value_) {
				if ($this->fieldTable_[$key_]->isValid()) {
					$this->fieldTable_[$key_]->delete();
				};
			};

			return true;
		};
		return false;
	}

	function setEmptyValue() {
		foreach ($this->queryField_ as $key_ => $value_) {
			$this->$key_ = new xyo_datasource_EmptyField();
		};
	}

	function load($start=null, $length=null) {

		$this->resultLoadAll_ = false;
		$this->resultLimitStart_ = $start;
		$this->resultLimitLength_ = $length;
		$this->resultRow_ = array();
		$this->resultCount_ = 0;

		$this->loadRecords_();
		$this->prepareResult_();

		$this->resultInLoadIndex_ = 0;
		$this->resultInLoadCount_ = $this->resultCount_;
		$this->resultInLoad_ = $this->resultRow_;
		if ($this->resultInLoadCount_) {
			if(empty($this->fieldSelect_)) {
				foreach ($this->queryField_ as $key_ => $value_) {
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

		$this->resultLoadAll_ = false;
		$this->resultLimitStart_ = $start;
		$this->resultLimitLength_ = $length;
		$this->resultRow_ = array();
		$this->resultCount_ = 0;

		$this->loadRecords_();
		$this->prepareResult_();

		$this->resultInLoadIndex_ = 0;
		$this->resultInLoadCount_ = $this->resultCount_;
		$this->resultInLoad_ = $this->resultRow_;
		if ($this->resultInLoadCount_) {
			if(empty($this->fieldSelect_)) {
				foreach ($this->queryField_ as $key_ => $value_) {
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
		if (!$this->resultCount_) {
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

	function checkRow_($row) {
		$retV = true;

		foreach ($this->queryField_ as $key_ => $value_) {
			if ($this->isEmpty($this->$key_)) {
				continue;
			};

			if (is_array($this->$key_)) {
				$found_ = false;
				foreach ($this->$key_ as $v_) {
					if ($this->isEmpty($row[$key_])) {
						if ($this->isEmpty($v_)) {

						} else {
							$retV = false;
							break;
						};
					} else {

						if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
						($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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
				};
				if ($found_) {
					$retV = true;
				};

				if ($retV) {

				} else {
					break;
				};
			} else {
				if ($this->isEmpty($row[$key_])) {
					$retV = false;
					break;
				} else {
					if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
					($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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
					if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="date") {
						$val_=strtotime($val_." 12:00:00");
						$v1=strtotime($v1." 00:00:00");
						$v2=strtotime($v2." 23:59:59");
					};
					if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="datetime") {
						$val_=strtotime($val);
						$v1=strtotime($v1);
						$v2=strtotime($v2);
					};

					if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
					($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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
					if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="date") {
						$val_=strtotime($val_." 12:00:00");
						$v1=strtotime($v1." 00:00:00");
						$v2=strtotime($v2." 23:59:59");
					};
					if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="datetime") {
						$val_=strtotime($val);
						$v1=strtotime($v1);
						$v2=strtotime($v2);
					};

					if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
					($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {

						if((strcasecmp($val_,$v1)>=0)&&(strcasecmp($val_,$v2)<=0)) {
						} else {
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
						if($chk==$v1) {
							$bRet=true;
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

						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
						($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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

						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
						($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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

						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
						($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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

						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="date") {
							$chk=strtotime($chk." 12:00:00");
							$v1=strtotime($v1." 12:00:00");
						};
						if($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="datetime") {
							$chk=strtotime($chk);
							$v1=strtotime($v1);
						};

						if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
						($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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

						if(($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="text")||
						($this->fieldTable_[$this->queryField_[$key_]]->fieldType_[$this->queryKey_[$key_]]=="varchar")) {
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

	function isValid() {
		foreach ($this->queryField_ as $key_ => $value_) {
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
				foreach ($this->queryField_ as $key_ => $value_) {
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

			if (array_key_exists($key_, $this->queryField_)) {
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

	function strDataSource() {
		$retV = "Array\r\n(\r\n";
		foreach ($this->queryField_ as $key_ => $value_) {
			if ($this->isEmpty($this->$key_)) {
				$retV.="\t[" . $key_ . "] => [ empty ]\r\n";
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


		foreach ($this->queryTable_ as $key2_ => $value2) {

			$retV.="\t[- " . $key2_ . " -] => Array\r\n\t\t(\r\n";
			foreach ($this->fieldTable_[$key2_]->fieldType_ as $key_ => $value_) {
				if ($this->isEmpty($this->fieldTable_[$key2_]->$key_)) {
					$retV.="\t\t\t[" . $key_ . "] => [ empty ]\r\n";
				} else {
					$retV.="\t\t\t[" . $key_ . "] => " . $this->fieldTable_[$key2_]->$key_ . "\r\n";
				};
			};
			$retV.="\t\t)\r\n";
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

	function clearWithNull($key_=false) {
		foreach ($this->queryField_ as $key_ => $value_) {
			$this->$key_ = null;
		};
		$this->fieldGroup_ = array();
		$this->fieldOrder_ = array();
		$this->fieldFunction_ = array();
		$this->fieldFunctionAs_ = array();
		$this->fieldOperator_ = array();
		$this->fieldSelect_=null;
	}

	function atomicAdd($field,$value) {
		return $this->fieldTable_[$this->primaryTable_]->atomicAdd($field,$value);
	}

	function atomicIncrement($field){
		return $this->atomicAdd($field,1);
	}

	function atomicSub($field,$value) {
		return $this->fieldTable_[$this->primaryTable_]->atomicSub($field,$value);
	}

	function atomicDecrement($field){
		return $this->atomicSub($field,1);
	}

}

