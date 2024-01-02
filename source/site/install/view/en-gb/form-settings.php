<?php
// Copyright (c) 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.form-text-icon-left",array("element"=>"website_title","icon"=>"<i class=\"material-icons\">dns</i>"));
$this->generateComponent("xui.form-username",array("element"=>"username","required"=>true));
$this->generateComponent("xui.form-password",array("element"=>"password","required"=>true));
$this->generateComponent("xui.form-password",array("element"=>"retype_password","required"=>true));
