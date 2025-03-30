<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
//
// Config
//

$select_info = $this->tableSelectInfo;

//
// Action
//

$has_search=false;
foreach ($this->tableSearch as $key => $value) {
	if ($value) {
		$has_search=true;
	};
};

$search_value = "";
if($has_search){
	$search_value = trim($this->getRequestInstance("search",""));
	$search_reset_= $this->getRequestInstance("search_reset",0);
	if(strlen("".$search_reset_)==0){
		$search_reset_=0;
	};
	$search_reset = 1*$search_reset_;
	if ($search_reset == 1) {
		$search_value = "";
		$has_search = false;
        };
};
$search_value=trim($search_value);
if(strlen($search_value)==0){
	$has_search = false;
};

$select_value = array();
foreach ($this->tableSelect as $key => $value) {
	if ($value) {
		$selectValue = $this->getRequestInstance("view_select_" . $key, null);
		if(!is_null($selectValue)) {
			$selectValue=trim($selectValue);
		};
		$select_value[$key] = $selectValue;
		$this->unsetKeepRequestInstance("view_select_" . $key);
		$this->setKeepRequestInstance("edit_select_" . $key,$select_value[$key]);
	}else{
		$select_value[$key]=null;
	};
};

$sortState = array();
foreach ($this->tableSort as $key => $value) {
	$sortState[$key] = $value;
};
$sort = $this->getRequestInstance("sort","");
if(strlen($sort)) {
	$sortList=explode(":",$sort);
	if(count($sortList)>1) {
		foreach ($this->tableSort as $key => $value) {
			$sortState[$key]= "none";
		};
		$sortState[$sortList[0]]=$sortList[1];
	};
};

$this->viewData = array();
$data = array();

$count = trim($this->getRequestInstance("count", 25));
$page = trim($this->getRequestInstance("page", 1));

$this->setKeepRequestInstance("view_count",$count);

if (1*$this->getRequestInstance("go_first")) {
	$page = 1;	
};

if (1*$this->getRequestInstance("go_previous")) {
	$page = $page - 1;
};

if ($page < 1) {
	$page = 1;
};
$nr_items = 0;

$select_value["count"] = $count;

$this->ds = &$this->getDataSource($this->applicationDataSource);
if ($this->ds) {
	$this->ds->clear();
	if($has_search){
		$this->ds->pushOperator("and");
		if(count($this->tableSearch)>1){
			$this->ds->pushOperator("(");
		};
		$orOp=false;
		foreach ($this->tableSearch as $key => $value) {
			if ($value) {
				if($orOp){
			    		$this->ds->pushOperator("or");
				};
				$this->ds->setOperator($key, "like",$search_value);
				$orOp=true;
            		};
		};
		if(count($this->tableSearch)>1){
    			$this->ds->pushOperator(")");
		};
	};

	foreach ($this->tableSelect as $key => $value) {
		if ($value) {
			if(strcmp($value,"multiple")==0) {
				if (strlen($select_value[$key])) {
					$listSelect=explode(",",$select_value[$key]);
					$isAll=false;
					foreach($listSelect as $listVSelect) {
						if(strcmp($listVSelect,"*")==0) {
							$isAll=true;
						};
					};
					if($isAll) {
						continue;
					};
					$this->ds->$key = $listSelect;
				};
				continue;
			}
			if (!(is_null($select_value[$key]) || (strlen($select_value[$key])==0))) {
				if (!($select_value[$key] === "*")) {
					$this->ds->$key = $select_value[$key];
				};
			};
		};
	};

	foreach ($this->tableSort as $key => $value) {
		if ($sortState[$key] === "ascendent") {
			$this->ds->setOrder($key, 1);
			continue;
		};
		if ($sortState[$key] === "descendent") {
			$this->ds->setOrder($key, 2);
			continue;
		};
	};

	$this->processModel("table-select");

	$nr_items = $this->ds->count();
	$x_count = $count;
	if ($count === "all") {
		$page = 1;
		$x_count = $nr_items;
	};

	$page_count = 1;
	if ($x_count > 0) {
		$page_count = ceil($nr_items / $x_count);
	};

	if (1*$this->getRequestInstance("go_last")) {
		$page = $page_count;		
	};

	if (1*$this->getRequestInstance("go_next")) {
		$page = $page + 1;
	};

	if ($page > ($page_count - 1)) {
		$page = $page_count;
	};
    
	if ($page < 1) {
		$page = 1;
	};
	
	$this->setKeepRequestInstance("view_page",$page);

	$index = 0;

	if($this->tableIsDelete){
		$this->ds->{$this->primaryKey}=$this->primaryKeyValue;
	};

	for ($this->ds->load((1 * $page - 1) * $x_count, $x_count); $this->ds->isValid(); $this->ds->loadNext()) {

		++$index;

		$this->viewData[$this->ds->{$this->primaryKey}] = array();
		$this->viewData[$this->ds->{$this->primaryKey}]["#"] = $index;
		$this->viewData[$this->ds->{$this->primaryKey}][$this->primaryKey] = $this->ds->{$this->primaryKey};
		$this->viewData[$this->ds->{$this->primaryKey}]["@write"] = true;
		foreach ($this->tableHead as $key => $value) {
			if ($key === "#")
				continue;
			if(!array_key_exists($key,$this->tableData)){
				$this->viewData[$this->ds->{$this->primaryKey}][$key] = $this->ds->$key;
			};
		};
		foreach ($this->tableData as $key => $value) {
			if(is_array($value)){
				$this->viewData[$this->ds->{$this->primaryKey}][$key] = $value[0];
			}else{
				$this->viewData[$this->ds->{$this->primaryKey}][$key] = $this->ds->$value;
			};
		};
	};

	$this->processModel("table-filter");
}else {
	$this->setError(array("error.datasource_not_found" => $this->applicationDataSource));
};

$select_info = array_merge($select_info, array(
	"count" => array(
		"5" => $this->getFromLanguage("select.count_5"),
		"10" => $this->getFromLanguage("select.count_10"),
		"15" => $this->getFromLanguage("select.count_15"),
		"25" => $this->getFromLanguage("select.count_25"),
		"50" => $this->getFromLanguage("select.count_50"),
		"100" => $this->getFromLanguage("select.count_100"),
		"all" => $this->getFromLanguage("select.count_all")
	))
);

$this->setParameterInstance("select.info", $select_info);
$this->setParameterInstance("search_value", $search_value);
$this->setParameterInstance("select.value", $select_value);
$this->setParameterInstance("nr_items", $nr_items);
$this->setParameterInstance("count", $count);
$this->setParameterInstance("page", $page);
$this->setParameterInstance("sortState", $sortState);

$this->toolbarParameter=array_merge($this->toolbarParameter,array(
	"dialog_new"=>$this->dialogNew_,
	"dialog_edit"=>$this->dialogEdit_,
	"inline_new"=>$this->inlineNew_,
	"inline_edit"=>$this->inlineEdit_
));

foreach($this->tableType as $key_=>$value_){
	if($value_[0]=="cmd-edit"){
		if(!$this->dialogEdit_){
			if(!$this->inlineEdit_){
				$this->tableType[$key_]=array_merge(array("action",array(
					"action" => "form-edit",
					"primary_key_value" => array($this->primaryKey)
				)),array_slice($this->tableType[$key_],1));
			};
		};
	};
};


