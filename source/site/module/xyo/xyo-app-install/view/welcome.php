<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.form-action-begin");


echo "<div class=\"float-right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"disabled",
	"try"=>"disabled",
	"next"=>"primary"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";
echo "<br />";

$this->generateViewLanguage("msg-welcome");

$this->eFormRequest(array(
	"back" => "welcome",
	"this" => "welcome",
	"next" => "package"
));

$this->generateComponent("xui.form-action-end");
