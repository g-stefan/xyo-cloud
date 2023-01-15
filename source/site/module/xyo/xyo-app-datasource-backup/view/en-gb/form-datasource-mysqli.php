<?php
// Copyright (c) 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT
defined("XYO_CLOUD") or die("Access is denied");

$this->setElementDefaultValue("server","localhost");
$this->setElementDefaultValue("port","3306");

$this->generateComponent("xui.form-text-icon-left",array("element"=>"server","icon"=>"<i class=\"material-icons\">dns</i>"));
$this->generateComponent("xui.form-text-icon-left",array("element"=>"port","icon"=>"<i class=\"material-icons\">swap_horiz</i>"));
$this->generateComponent("xui.form-username",array("element"=>"username"));
$this->generateComponent("xui.form-password",array("element"=>"password"));
$this->generateComponent("xui.form-text-icon-left",array("element"=>"database","icon"=>"<i class=\"material-icons\">storage</i>"));
$this->generateComponent("xui.form-text-icon-left",array("element"=>"prefix","icon"=>"<i class=\"material-icons\">device_hub</i>"));
                                                        
?>
<br />
<div class="xui alert -info">
Notice: Database must already exists on your server before backup.
</div>
