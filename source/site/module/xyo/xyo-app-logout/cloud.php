<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setModuleAsApplication($module);
$this->setReferenceLink($module,"xyo-mod-ds-loader-mod");
$this->setReferenceLink($module,"xyo-mod-ds-user");
$this->setVersion($module, "1.0.0");
