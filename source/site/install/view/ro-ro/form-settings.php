<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.form-text-icon-left",array("element"=>"website_title","icon"=>"<i class=\"material-icons\">dns</i>"));
$this->generateComponent("xui.form-username-required",array("element"=>"username"));
$this->generateComponent("xui.form-password-required",array("element"=>"password"));
$this->generateComponent("xui.form-password-required",array("element"=>"retype_password"));
