<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->removeItem("new");
$this->removeItem("delete");

$this->toolbarPush();

$this->setItem(
	"backup",
	"item-js",
	"<i class=\"lucide-database\"></i>",
	"backup",
	"primary",
	"#",
	"callDatasourceBackup();"
);

$this->setItem("separator-table","separator",null,null,null,null,null);

$this->toolbarPop();
