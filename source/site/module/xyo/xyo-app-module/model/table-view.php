<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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
