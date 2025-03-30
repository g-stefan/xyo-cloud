<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
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

$this->ecssBegin();
echo ".xyo-app-table.-x-delete-1{width:100%}";
$this->ecssEnd();

echo "<table class=\"xui-table xyo-app-table -x-delete-1\">";
include("table-view.sub.php");
echo "</table>";

if($hasMore){
	$this->eLanguage("delete.this_and_many_more");
};

