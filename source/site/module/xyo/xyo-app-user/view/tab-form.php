<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.box-1x2-begin");

$this->generateComponent("xui.panel-begin");
$this->generateComponent("xui.form-image", array("element" =>"picture","view_x"=>320,"view_y"=>320));
$this->generateComponent("xui.form-textarea", array("element" =>"description"));
$this->generateComponent("xui.panel-end");

$this->generateComponent("xui.box-1x2-separator");

$this->generateComponent("xui.panel-begin");
$this->generateComponent("xui.form-text-required", array("element" =>"name"));
$this->generateComponent("xui.form-username-required", array("element" =>"username","autocomplete"=>"off"));

if($this->isNew){
	$this->generateComponent("xui.form-password-required", array("element" =>"password1","autocomplete"=>"new-password"));
	$this->generateComponent("xui.form-password-required", array("element" =>"password2","autocomplete"=>"off"));
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
