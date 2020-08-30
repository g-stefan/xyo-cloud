<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->removeItem("new");
$this->removeItem("delete");

$this->setItemBefore("edit",
	"backup",
	"item-js",
	"<i class=\"material-icons\">storage</i>",
	"backup",
	"primary",
	"#",
	"callDatasourceBackup();"
);
