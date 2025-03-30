<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if(!$this->isDialog){
	$this->generateComponent("xui.box-1x1-begin");
	$this->generateComponent("xui.panel-begin");
};

if (!$this->xyo_module_id) {   
	$this->generateComponent("xui.form-select", array("element" => "xyo_module_id", "minimum_results_for_search"=> 15));
};

if (!$this->xyo_module_group_id) {
	$this->generateComponent("xui.form-select", array("element" => "xyo_module_group_id", "minimum_results_for_search"=> 15));
};

$this->generateComponent("xui.form-order", array("element" => "order"));
$this->generateComponent("xui.form-select", array("element" => "xyo_core_id", "minimum_results_for_search"=> 15));
$this->generateComponent("xui.form-select", array("element" => "xyo_user_group_id", "minimum_results_for_search"=> 15));
$this->generateComponent("xui.form-switch", array("element" => "enabled"));

if(!$this->isDialog){
	$this->generateComponent("xui.panel-end");
	$this->generateComponent("xui.box-1x1-end");
};
