<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
