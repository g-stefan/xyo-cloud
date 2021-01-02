<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setModuleAsApplication($module);
$this->setReferenceBase($module, "xyo-app-application");
$this->setReferenceLink($module, "lib-font-awesome");
$this->setReferenceLink($module, "lib-jquery-form");
$this->setVersion($module, "1.0.0");

$this->setReferenceLink($module, "lib-xui");
