<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title","Module");

$this->set("head.name","Name");
$this->set("head.description","Description");
$this->set("head.element","Element");
$this->set("head.id","Id");

$this->set("label.name","Name");
$this->set("label.parent","Parent");
$this->set("label.path","Path");
$this->set("label.element","Element");
$this->set("label.description","Description");

$this->set("info.package_uninstall_ok","Package uninstalled");
$this->set("info.package_created_ok","Package created");

$this->set("title.default_acl","Default ACL");
$this->set("select.xyo_module_group_any","- module group -");
$this->set("label.xyo_module_group_id","Module group");
$this->set("label.order","Order");  
$this->set("label.xyo_user_group_id","User group");
$this->set("label.acl_enabled","Enabled");

$this->set("select.xyo_user_group_any","- user group -");

$this->set("select.xyo_module_group_any_edit","- none -");
$this->set("select.xyo_user_group_any_edit","- any -");

$this->set("label.xyo_core_id","Core");
$this->set("select.xyo_core_any_edit","- any -");

$this->set("info.version","Version");
$this->set("info.author","By");
$this->set("info.site","Website");
$this->set("info.license","License");
