<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("table_primary_key", "id");

$this->set("table_item", array(
	"id" => array("bigint","DEFAULT","unsigned","auto_increment"),
	"name" => array("varchar",null,128),
	"connection" => array("varchar",null,128)
));

// ---

$this->set("memory_load",function(&$dsMemory){

	$connectionProviderList=array_keys($this->cloud->dataSource->getDataSourceConnectionProviderList());
	$connectionTable=array();
	foreach($connectionProviderList as $key=>$value){
		$connectionTable[]=array($value.".table.",$value);
	};

	$rowList=array();
	$rowList[0]=array("id","name","connection");

	$path="datasource";
	if ($dir = @opendir($path)){
		while (false !== ($obj = readdir($dir))) {
			if ($obj == '.' || $obj == '..') {
				continue;
			};
			if (!is_dir($path . $obj)) {
				foreach($connectionTable as $key=>$connection) {
					if(strncmp($obj,$connection[0],strlen($connection[0]))==0){
						array_push($rowList,array(
							count($rowList),
							str_replace(".php","",$obj),
							$connection[1]
						));
						break;
					};
				};
			};
		};
		closedir($dir);
	};
	
	return $rowList;
});

