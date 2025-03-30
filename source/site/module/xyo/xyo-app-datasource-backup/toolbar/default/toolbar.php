<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setItem("backup",
	"item-js",
	"<i class=\"lucide-database-backup\"></i>",
	"backup",
	"primary",
	"#",
	$this->instanceV."doCommand('datasource-check');"
);

if($this->isRequestCall()){
	$this->setItem("separator-done","separator",null,null,null,null,null);

	$this->setItem("done",
		"item-js",
		"<i class=\"lucide-check\"></i>",
		"done",
		"info",
		"#",
		$this->instanceV."doReturn();"
	);
};
