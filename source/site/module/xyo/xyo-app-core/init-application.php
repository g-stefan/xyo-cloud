<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"material-icons\">device_hub</i>");
$this->setApplicationDataSource("db.table.xyo_core");
$this->setPrimaryKey("id");

$this->setDialogNew(true);
$this->setDialogEdit(true);

$this->requireComponent(array(
	"xui.form-select",
	"xui.form-text",	
	"xui.form-textarea",
	"xui.form-switch",
	"xui.panel-begin",
	"xui.panel-end",
	"xui.box-1x1-begin",
	"xui.box-1x1-end"
));
