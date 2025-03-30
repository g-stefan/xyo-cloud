<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setElementDefaultValue("server","localhost");
$this->setElementDefaultValue("port","3306");

$this->generateComponent("xui.form-text-icon-left",array("element"=>"server","icon"=>"<i class=\"lucide-server\"></i>"));
$this->generateComponent("xui.form-text-icon-left",array("element"=>"port","icon"=>"<i class=\"lucide-arrow-right-left\"></i>"));
$this->generateComponent("xui.form-username",array("element"=>"username"));
$this->generateComponent("xui.form-password",array("element"=>"password"));
$this->generateComponent("xui.form-text-icon-left",array("element"=>"database","icon"=>"<i class=\"lucide-database\"></i>"));
$this->generateComponent("xui.form-text-icon-left",array("element"=>"prefix","icon"=>"<i class=\"lucide-shuffle\"></i>"));


?>
<div class="xui-alert --info">
Nota: Baza de date trebuie sa existe pe server inainte de salvare.
</div>
