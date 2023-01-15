<?php
// Copyright (c) 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"material-icons\">storage</i>");
$this->setDefaultAction($this->getRequest("action", "default"));

$this->requireComponent(array(
	"xui.form-select",
	"xui.form-text-icon-left",
	"xui.form-username",
	"xui.form-password",
	"xui.panel-begin",
	"xui.panel-end",
	"xui.box-1x1-begin",
	"xui.box-1x1-end",
));
                      
$this->requireModule("lib-xui");
