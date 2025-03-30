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
	"next"=>"disabled"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";

$this->generateViewLanguage("msg-already-configured");


$this->eFormRequest(array(
	"back" => "already-configured",
	"this" => "already-configured",
	"next" => "already-configured",
	"website_language" => $this->getSystemLanguage()
));

$this->generateComponent("xui.form-action-end");
echo "<div class=\"clear-both h-4\"></div>";
