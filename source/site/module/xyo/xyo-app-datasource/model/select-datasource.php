<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$select=array("*"=>$this->getFromLanguage("select.datasource_none"));
$connection=$this->getElementValueString("connection","");
if(strlen($connection)>0){
	$connectionX=$connection.".table.";

	$list = array();
	$path="datasource";
	if ($dh = @opendir($path)){
		while (false !== ($obj = readdir($dh))) {
			if ($obj == '.' || $obj == '..') {
				continue;
			};
			if (is_dir($path . $obj)) {
			} else {
				array_push($list, $obj);
			};
		};
		closedir($dh);
	};

	foreach($list as $value){	
		if(strncmp($value,$connectionX,strlen($connectionX))==0){
			$valueX=str_replace(".php","",$value);
			$select[$valueX]=$valueX;
		};
	};

};

ksort($select);

$this->setParameter("select.datasource",$select);
