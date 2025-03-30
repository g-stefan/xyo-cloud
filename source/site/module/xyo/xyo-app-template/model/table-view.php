<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->tableHead = array(
	"#" => "#",
	"module_name" => "head.module_name",
	"active" => "head.active",
	"core_name" => "head.core_name"
);

$this->tableSearch = array(
	"module_name" => true
);

$this->tableSelect = array(
	"xyo_core_id" => true
);

$this->tableType=array(
	"module_name"=>array("custom","template-info"),
	"active"=>array("toggle",array(
		"on"=>array(
			0=>array("<i class=\"lucide-circle\"></i>","toolbar"),
			1=>array("<i class=\"lucide-circle-check-big\"></i>","primary")
		),
		"force-command"=>true
	))
);

$this->tableSort = array(
	"module_name" => "ascendent",
	"active" => "none",
	"core_name" => "none"
);

$this->processModel("select-xyo-core");

$this->tableSelectInfo = array(
	"xyo_core_id" => $this->getParameter("select.xyo_core_id", array())
);

$this->tableActionLink = array();

$this->tableData = array(
	"xyo_core_id"=>"xyo_core_id",
	"xyo_module_id"=>"xyo_module_id",
	"active"=>array(0=>0)
);

$this->tableImportant=array(
	"module_name" => true,
	"active" => true
);
