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
	"next"=>"disabled"
)));
echo "</div>";
echo "<div class=\"xui separator\"></div>";
echo "<br />";

$this->generateViewLanguage("msg-already-configured");


$this->eFormRequest(array(
	"back" => "already-configured",
	"this" => "already-configured",
	"next" => "already-configured",
	"website_language" => $this->getSystemLanguage()
));

$this->generateComponent("xui.form-action-end");
