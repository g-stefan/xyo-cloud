<?php
// Copyright (c) 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.form-action-begin");

echo "<div class=\"xui -right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"disabled",
	"try"=>"disabled",
	"next"=>"primary"
)));
echo "</div>";
echo "<div class=\"xui separator\"></div>";
echo "<br />";

if ($this->isError()) {
	$this->generateView("msg-error");
}

$this->generateViewLanguage("form-settings");

$this->eFormRequest(array(
	"back" => "install",
	"this" => "settings",
	"next" => "settings-step",
	"website_language" => $this->getSystemLanguage(),
	"select" => "settings"
));

$this->generateComponent("xui.form-action-end");
