<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setViewTemplate("template");
$this->setDefaultAction($this->getRequestInstance("action", "default"));

$this->requireComponent(array(
	"xui.form-action-begin",
	"xui.form-action-end",
	"xui.box-space"
));
