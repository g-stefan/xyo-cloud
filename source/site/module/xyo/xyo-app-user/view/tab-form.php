<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$isAdministrator=($this->user->isInGroup("wheel")||$this->user->isInGroup("administrator"));

$this->generateComponent("xui.box-1x2-begin");

$this->generateComponent("xui.panel-begin");
$this->generateComponent("xui.form-image", array("element" =>"picture","view_x"=>320,"view_y"=>320));
$this->generateComponent("xui.form-textarea", array("element" =>"description"));
$this->generateComponent("xui.panel-end");

$this->generateComponent("xui.box-1x2-separator");

$this->generateComponent("xui.panel-begin");

if($isAdministrator) {
	$this->generateComponent("xui.form-text", array("element" => "name","required"=>true));
	$this->generateComponent("xui.form-username", array("element" =>"username","autocomplete"=>"off","required"=>true));
} else{ 
	$this->generateComponent("xui.form-text-icon-right", array("element" => "name", "readonly" => true, "icon"=>"<i class=\"lucide-shield\"></i>"));
	$this->generateComponent("xui.form-text-icon-right", array("element" => "username", "readonly" => true, "icon"=>"<i class=\"lucide-shield\"></i>"));
};

if($this->isNew){
	$this->generateComponent("xui.form-password", array("element" =>"password1","autocomplete"=>"new-password","required"=>true));
	$this->generateComponent("xui.form-password", array("element" =>"password2","autocomplete"=>"off","required"=>true));
} else {
	$this->generateComponent("xui.form-password", array("element" =>"password1","autocomplete"=>"new-password"));
	$this->generateComponent("xui.form-password", array("element" =>"password2","autocomplete"=>"off"));
};

$this->generateComponent("xui.form-email", array("element" =>"email"));

if($this->isNew){
	$this->generateComponent("xui.form-select", array("element" =>"xyo_user_group_id"));
};

$this->generateComponent("xui.form-select", array("element" =>"xyo_language_id"));
$this->generateComponent("xui.form-switch", array("element" =>"invisible"));
$this->generateComponent("xui.form-switch", array("element" =>"enabled"));

$this->generateView("tab-form-derived");

if($this->isNew){
	$this->generateComponent("xui.form-action-apply",array("click"=>$this->instanceV."doCommand('form-new-apply');"));
}else{
	$this->generateComponent("xui.form-action-apply",array("click"=>$this->instanceV."doCommand('form-edit-apply');"));
};

$this->generateComponent("xui.panel-end");

$this->generateComponent("xui.box-1x2-end");
