<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->tableHead=array(
	"#" => "#",
	"name"=>"head.name",
	"description"=>"head.description",
	"enabled"=>"head.enabled"			 
);

$this->tableSearch=array(
	"name" => true
);

$this->tableSelect=array(
	"enabled" => true
);

$this->tableType=array(
	"name" => array("custom","module-info"),
	"enabled" => array("toggle")			
);

$this->tableSort=array(
	"name" => "ascendent",
	"description" => "none",
	"version"=>"none",
	"enabled"=>"none"
);

$this->processModel("select-enabled");

$this->tableSelectInfo=array(
	"enabled" => $this->getParameter("select.enabled",array())
);

$this->tableImportant=array(
	"name"=>true
);
