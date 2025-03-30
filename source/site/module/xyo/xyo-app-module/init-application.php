<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"lucide-puzzle\"></i>");
$this->setApplicationDataSource("db.table.xyo_module");
$this->setPrimaryKey("id");

$this->setDialogNew(true);
$this->setDialogEdit(true);

$this->requireComponent(array(
	"xui.form-select",
	"xui.form-text",	
	"xui.form-textarea",
	"xui.form-order",
	"xui.form-switch",
	"xui.form-action-apply",

	"xui.panel-begin",
	"xui.panel-end",
	"xui.box-1x2-begin",
	"xui.box-1x2-separator",
	"xui.box-1x2-end",
	"xui.box-1x1-begin",
	"xui.box-1x1-end"
));
