<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title","ACL Module");
$this->set("head.module_name","Modul");
$this->set("head.module_group_name","Grup modul");
$this->set("head.order","Ordine");
$this->set("head.core_name","Core");
$this->set("head.user_group_name","Grup utilizator");
$this->set("head.id","Id");


$this->set("select.xyo_user_group_any","- grup utilizator -");
$this->set("select.xyo_module_group_any","- grup modul -");
$this->set("select.xyo_core_any","- core -");

$this->set("label.xyo_module_id","Modul");
$this->set("select.xyo_module_any","- modul -");
$this->set("label.xyo_module_group_id","Grup modul");
$this->set("select.xyo_module_group_any","- grup -");
$this->set("label.order","Ordine");

$this->set("label.xyo_user_group_id","Grup utilizator");

$this->set("select.xyo_module_group_any_edit","- nici unul -");
$this->set("select.xyo_core_any_edit","- oricare -");
$this->set("select.xyo_user_group_any_edit","- oricare -");
$this->set("select.xyo_module_any_edit","- nici unul -");

$this->set("label.xyo_core_id","Core");