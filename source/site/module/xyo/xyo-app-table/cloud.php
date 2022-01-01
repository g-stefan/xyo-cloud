<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setModuleAsApplication($module);
$this->setReferenceBase($module, "xyo-app-application");
$this->setReferenceLink($module, "lib-jquery-form");
$this->setReferenceLink($module, "xyo-mod-app-search");
$this->setVersion($module, "1.0.0");

$this->setReferenceLink($module, "lib-xui");
