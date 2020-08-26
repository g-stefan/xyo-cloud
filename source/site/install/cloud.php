<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setModuleAsApplication($module);
$this->setReferenceLink($module, "xyo-mod-setup");
$this->setReferenceLink($module, "lib-material-icons");
$this->setReferenceLink($module, "lib-xui");
$this->setReferenceBase($module, "xyo-mod-application");
$this->setVersion($module, "1.0.0");
