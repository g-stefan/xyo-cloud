<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->addItem("xui.box-1x2-begin");
$this->addItem("xui.panel-begin");

$this->addItem("xui.form-text", "website_title","");
$this->addItem("xui.form-integer", "user_logoff_after_idle_time",15);
$this->addItem("xui.form-switch", "user_action",1);
$this->addItem("xui.form-switch", "user_captcha",1);

$this->addItem("xui.form-action-apply",null,null,array("click"=>$this->instanceV."doCommand('form-edit-apply');"));

$this->addItem("xui.panel-end");
$this->addItem("xui.box-1x2-separator");
$this->addItem("xui.panel-begin",null,null,array("title"=>"title.log"));

$this->addItem("xui.form-switch", "log_module",0);
$this->addItem("xui.form-switch", "log_request",0);
$this->addItem("xui.form-switch", "log_response",0);
$this->addItem("xui.form-switch", "log_language",0);

$this->addItem("xui.panel-end");

$this->addItem("xui.panel-begin",null,null,array("title"=>"title.login"));
$this->addItem("xui.form-switch", "login_has_select_language",0);
$this->addItem("xui.panel-end");

$this->addItem("xui.panel-begin",null,null,array("title"=>"title.security"));
$this->addItem("xui.form-switch", "csrf_token_refresh",0);
$this->addItem("xui.panel-end");

$this->addItem("xui.box-1x2-end");

$this->addItem("xui.box-1x2-begin");
$this->addItem("xui.panel-begin");

$this->addItem("xui.form-image","brand_logo","",array(
	"view_x"=>256,
	"view_y"=>256,
	"filename"=>"repository/template/brand-logo-".time(),
	"extension"=>true,
	"delete_before_save"=>true,
	"make_thumbnails" => array(
		array(32,32)
	)
));

$this->addItem("xui.panel-end");
$this->addItem("xui.box-1x2-separator");
$this->addItem("xui.panel-begin");

$this->addItem("xui.form-text", "brand_name","Cloud");
$this->addItem("xui.form-text", "brand_mark","");

$this->addItem("xui.panel-end");
$this->addItem("xui.box-1x2-end");
