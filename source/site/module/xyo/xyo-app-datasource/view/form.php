<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.box-1x1-begin");
$this->generateComponent("xui.panel-begin");
$this->generateComponent("xui.form-select", array("element" => "connection","submit"=>true));
$this->generateComponent("xui.form-select", array("element" => "datasource"));
$this->generateComponent("xui.form-select", array("element" => "option"));
$this->generateComponent("xui.form-action-apply", array("click" => $this->instanceV."doCommand('form-edit-apply');"));
$this->generateComponent("xui.panel-end");
$this->generateComponent("xui.box-1x1-end");
