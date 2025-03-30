<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_datasource_sqlite_Query extends xyo_Config {

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
	var $primaryTable_;
	//-----

	var $hasNextValue_;

	var $fieldOperator_;

	var $fieldSelect_;

	function __construct(&$module, &$connection, $name, $datasource, $descriptor, $doInit=true) {
		parent::__construct($module->getCloud());

		$this->module_ = &$module;
		$this->connection_ = &$connection;
		$this->name_ = $name;
		$this->datasource_ = $datasource;		
		$this->descriptor_=$descriptor;


		$this->isOk_ = false;

		if ($doInit) {

			$this->isOk_ = $this->includeFile($this->descriptor_);

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

			$this->hasNextValue_ = null;

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
		$retV = new xyo_datasource_sqlite_Query($this->module_, $this->connection_, $this->name_, $this->datasource_, $this->descriptor_, false);
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

			$retV->fieldOperator_ = $this->fieldOperator_;

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
			$this->fieldOrder_[$key_] = $value_;
			return;
		}
	}

	function setGroup($key_, $value_) {
		if (array_key_exists($key_, $this->queryField_)) {
			$this->fieldGroup_[$key_] = $value_;
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

	function getWhereQuery() {
		$where = null;
		foreach ($this->queryField_ as $key_ => $value_) {
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
					$where .= "[" . $this->queryField_[$value_[1]] . "_].[" . $this->queryKey_[$value_[1]] . "]";
					if($value_[2]==1) {
						if($value_[7]) {
							$where .= ",".$this->getQueryValue($value_[1],$value_[5]).")";
						};
					};
					$where .= $value_[3];
					if($value_[2]==0) {
					} else if($value_[2]==1) {
						if($value_[6]) {
							$where .= "[" . $this->queryField_[$value_[4]] . "_].[" . $this->queryKey_[$value_[4]] . "]";
						} else {
							$where.= $this->getQueryValue($value_[1],$value_[4]);
						};
					} else if($value_[2]==2) {
						if($value_[6]) {
							$where .= "[" . $this->queryField_[$value_[4]] . "_].[" . $this->queryKey_[$value_[4]] . "]";
						} else {
							$where.= $this->getQueryValue($value_[1],$value_[4]);
						};

						$where.=" AND ";

						if($value_[7]) {
							$where .= "[" . $this->queryField_[$value_[5]] . "_].[" . $this->queryKey_[$value_[5]] . "]";
						} else {
							$where.= $this->getQueryValue($value_[1],$value_[5]);
						};
					} else if($value_[2]==3) {
						if($value_[6]) {
							$where .= "[" . $this->queryField_[$value_[4]] . "_].[" . $this->queryKey_[$value_[4]] . "]";
						} else {
							$where.= "'%" . $this->connection_->safeLikeValue($value_[4]) . "%'";
						};
					}


				}
			}

		}

		return $where;
	}


	function getLoadQuery($query=null, $inCount=false) {

		if ($query == null) {
			if(empty($this->fieldSelect_)) {

				foreach ($this->queryField_ as $key_ => $value_) {
					if ($query) {
						$query.=",[" . $value_ . "_].[" . $this->queryKey_[$key_] . "] AS [" . $key_ . "] ";
					} else {
						$query = "SELECT [" . $value_ . "_].[" . $this->queryKey_[$key_] . "] AS [" . $key_ . "] ";
					};
				}

			} else {

				foreach ($this->queryField_ as $key_) {
					if ($query) {
						$query.=",[" . $value_ . "_].[" . $this->queryKey_[$key_] . "] AS [" . $key_ . "] ";
					} else {
						$query = "SELECT [" . $value_ . "_].[" . $this->queryKey_[$key_] . "] AS [" . $key_ . "] ";
					};
				}

			}

			foreach ($this->fieldFunction_ as $key_ => $value_) {
				$query.="," . $value_ . "([" . $this->queryField_[$key_] . "_].[" . $this->queryKey_[$key_] . "]) AS [" . $this->fieldFunctionAs_[$key_] . "]";
			};
		};

		$from = "";
		foreach ($this->queryMode_ as $key_ => $value_) {
			if ($value_ == "base") {
				$from.=" FROM [" . $this->fieldTable_[$key_]->realName_ . "] AS [" . $key_ . "_] ";
			};
		};

		foreach ($this->queryMode_ as $key_ => $value_) {
			if ($value_ == "base") {
				continue;
			}
			if ($value_ == "outer") {
				$from.=" LEFT OUTER JOIN [" . $this->fieldTable_[$key_]->realName_ . "] AS [" . $key_ . "_] ON ";
				$from.="[" . $this->queryFirstTable_[$key_] . "_].[" . $this->queryFirstKey_[$key_] . "]=";
				$from.="[" . $this->querySecondTable_[$key_] . "_].[" . $this->querySecondKey_[$key_] . "]";
			};
		};


		$query.=$from;
		$query.=$this->getWhereQuery();

		$group = null;
		foreach ($this->fieldGroup_ as $key_ => $value_) {
			if ($value_) {
				if ($group) {
					$group.=",[" . $this->queryField_[$key_] . "_].[" . $this->queryKey_[$key_] . "]";
				} else {
					$group = "GROUP BY [" . $this->queryField_[$key_] . "_].[" . $this->queryKey_[$key_] . "]";
				};
			};
		};
		if ($group) {
			$query.=" " . $group;
		};

		if ($inCount) {

		} else {


			$order = null;
			foreach ($this->fieldOrder_ as $key_ => $value_) {
				if ($value_) {
					if ($order) {
						$order.=",[" . $this->queryField_[$key_] . "_].[" . $this->queryKey_[$key_] . "]";

						if ($value_ == $this->orderAscendent) {
							$order.=" ASC";
						} else if ($value_ == $this->orderDescendent) {
							$order.=" DESC";
						};
					} else {
						$order = "ORDER BY [" . $this->queryField_[$key_] . "_].[" . $this->queryKey_[$key_] . "]";
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
		}

		return $query;
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

	function getQueryWhereClauseForFieldOnValue($field_as, $field_this, $value_) {

		$where = "[" . $this->queryField_[$field_as] . "_].[" . $this->queryKey_[$field_as] . "]";
		$where.="=" . $this->getQueryValue($field_this, $value_);
		return $where;
	}

	function getQueryWhereClauseForField($field_as, $field_this) {
		$value_ = $this->$field_this;

		if (is_array($value_)) {
			if (count($value_) == 1) {
				foreach ($value_ as $v) {
					$value_ = $v;
					break;
				};
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

	function tryLoad($start=null, $length=null) {

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
		foreach ($this->queryField_ as $key_ => $value_) {
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

		$retV.= ")\r\n";
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

