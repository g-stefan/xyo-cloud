<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->tableHead = array(
	"#" => "#",
	"name" => "head.name",
	"connection" => "head.connection"
);

$this->tableSearch = array(
	"name" => true
);

$this->tableSelect = array(
	"connection" => true
);

$this->tableType = array(
	"name" => array("cmd-edit")
);

$this->tableSort = array(
	"name" => "ascendent",
	"connection" => "none"
);

$this->processModel("select-connection");

$this->tableSelectInfo = array(
	"connection" => $this->getParameter("select.connection", array())
);

$this->tableImportant=array(
	"name"=>true
);
