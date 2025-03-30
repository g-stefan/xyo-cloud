<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

//
$this->setModule(null,null,"xyo");
//
$this->setModule("xyo",null,"xyo-mod-application");
$this->setModule("xyo",null,"xyo-mod-ds-acl");
$this->setModule("xyo",null,"xyo-mod-ds-loader-mod");
$this->setModule("xyo",null,"xyo-mod-ds-user");
$this->setModule("xyo",null,"xyo-mod-crypt-rpc");
$this->setModule("xyo",null,"xyo-mod-setup");
$this->setModule("xyo",null,"xyo-mod-thumbnail");
//
$this->setModule("xyo",null,"xyo-mod-xui-menu");
$this->setModule("xyo",null,"xyo-mod-xui-sidebar");
$this->setModule("xyo",null,"xyo-mod-xui-user");
$this->setModule("xyo",null,"xyo-app-dashboard");
$this->setModule("xyo",null,"xyo-mod-app-search");
//
