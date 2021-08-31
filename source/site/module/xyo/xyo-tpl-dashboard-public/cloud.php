<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setReferenceLink($module, "xyo-mod-xui-sidebar");
$this->setReferenceLink($module, "lib-roboto-regular");
$this->setReferenceLink($module, "xyo-mod-app-search");

$this->setReferenceBase($module, "xyo-mod-application");
$this->setVersion($module, "1.0.0");

$this->setTemplate($module);
$this->setDefaultApplication("xyo-app-dashboard");

//
//
//
$this->setReferenceLink($module, "lib-material-icons");
$this->setReferenceLink($module, "lib-overlayscrollbars");
$this->setReferenceLink($module, "lib-xui");
