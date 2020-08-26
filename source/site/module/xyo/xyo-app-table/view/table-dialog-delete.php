<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->generateView("notify-alert");
$this->generateView("notify-error");

// ---

$count=0;
if(count($this->tableDelete)>0){
	$this->tableHead=array();
	foreach($this->tableDelete as $key=>$value){
		$this->tableHead[$key]="head.".$key;
	};
};
$hasMore=false;
if(count($this->viewData)>10){
	$this->viewData=array_slice($this->viewData,0,10);
	$hasMore=true;
};
$filterHead=array();
foreach($this->tableHead as $key=>$value){
	if($key=="#"){
		continue;
	};
	$filterHead[$key]=$value;
};
$this->tableHead=$filterHead;
$this->tableSort=array();
foreach($this->viewData as $key=>$value){
	$this->viewData[$key]["@write"]=0;
};

include("table-view.init.php");

echo "<table class=\"xui table -danger xyo-app-table\" style=\"width:100%\">";
include("table-view.sub.php");
echo "</table>";

if($hasMore){
	$this->eLanguage("delete.this_and_many_more");
};

