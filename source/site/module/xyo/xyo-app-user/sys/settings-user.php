<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->addItem("xui.box-1x1-begin");
$this->addItem("xui.panel-begin");
$this->addItem("xui.form-switch", "inline_form",0);
$this->addItem("xui.form-action-cancel-or-apply",null,null,array(
	"clickCancel" => "doReturn();return false;",
	"click" => "doCommand('form-edit-apply');return false;"
));
$this->addItem("xui.panel-end");
$this->addItem("xui.box-1x1-end");