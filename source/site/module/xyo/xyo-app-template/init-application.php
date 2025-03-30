<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationDataSource("db.query.xyo_acl_module");
$this->setPrimaryKey("id");

$this->setApplicationIcon("<i class=\"lucide-layout-template\"></i>");

$this->requireComponent(array(
	"xui.form-select",
	"xui.form-text",
	"xui.form-textarea",
	"xui.panel-begin",
	"xui.panel-end",
	"xui.box-1x1-begin",
	"xui.box-1x1-end"
));
