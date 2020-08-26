<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

echo "<div class=\"xui box -space\"></div>";

$this->generateComponent("xui.box-2x1-begin");
$this->runModule("xyo-app-user-x-user-group");
$this->generateComponent("xui.box-2x1-end");

echo "<div class=\"xui box -space\"></div>";
