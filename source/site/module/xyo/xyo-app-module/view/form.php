<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if($this->isNew){
	$this->generateComponent("xui.box-1x2-begin");
}else{
	if(!$this->isDialog){
		$this->generateComponent("xui.box-1x1-begin");
	};
};

if(!$this->isDialog){
	$this->generateComponent("xui.panel-begin");
};


$this->generateComponent("xui.form-text", array("element" => "name","required"=>true));
$this->generateComponent("xui.form-text", array("element" => "parent"));
$this->generateComponent("xui.form-text", array("element" => "path"));
$this->generateComponent("xui.form-textarea", array("element" => "description"));
$this->generateComponent("xui.form-switch", array("element" => "enabled"));

if($this->isNew){
	if(!$this->isDialog){
		$this->generateComponent("xui.form-action-apply",array("click"=>$this->instanceV."doCommand('form-new-apply');"));	
	};
};

if(!$this->isDialog){
	$this->generateComponent("xui.panel-end");
};


if($this->isNew){
	$this->generateComponent("xui.box-1x2-separator",array("css-class"=>"-border-left"));

	$this->generateComponent("xui.panel-begin", array("title"=>"title.default_acl","css-class"=>"-nested -form -no-border","no-top-space"=>true));
	$this->generateComponent("xui.form-select", array("element" =>"xyo_module_group_id"));
	$this->generateComponent("xui.form-order", array("element" =>"order"));
	$this->generateComponent("xui.form-select", array("element" =>"xyo_core_id"));
	$this->generateComponent("xui.form-select", array("element" =>"xyo_user_group_id"));
	$this->generateComponent("xui.form-switch", array("element" =>"acl_enabled"));
	$this->generateComponent("xui.panel-end");

	$this->generateComponent("xui.box-1x2-end");
}else{
	if(!$this->isDialog){
		$this->generateComponent("xui.box-1x1-end");
	};
};
