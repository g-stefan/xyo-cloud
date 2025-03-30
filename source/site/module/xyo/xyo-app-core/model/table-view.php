<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->tableHead = array(
	"#" => "#",
	"name" => "head.name",
	"path" => "head.path",
	"default" => "head.default",
	"description" => "head.description",
	"enabled" => "head.enabled"
);

$this->tableSearch = array(
	"name" => true
);

$this->tableSelect = array(
	"enabled" => true
);

$this->tableType = array(
	"name" => array("cmd-edit"),
	"default"=>array("radio",array(
		"on"=>array(
			0=>array("<i class=\"lucide-circle\"></i>","toolbar"),
			1=>array("<i class=\"lucide-circle-check-big\"></i>","primary")
		)
	)),
	"enabled"=>array("toggle")
);

$this->tableSort = array(
	"name" => "ascendent",
	"path" => "none",
	"default" => "none",
	"description" => "none",
	"enabled" => "none"
);

$this->processModel("select-enabled");

$this->tableSelectInfo = array(
	"default" => $this->getParameter("select.enabled", array()),
	"enabled" => $this->getParameter("select.enabled", array())
);

$this->tableImportant=array(
	"name"=>true
);
