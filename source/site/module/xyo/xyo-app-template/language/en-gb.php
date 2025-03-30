<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title","Template");

$this->set("head.module_name","Template");
$this->set("head.module_group_name","Module group");
$this->set("head.order","Order");
$this->set("head.core_name","Core");
$this->set("head.user_group_name","User group");
$this->set("head.active","Active");
$this->set("head.id","Id");

$this->set("select.xyo_core_any","- core -");
$this->set("select.xyo_user_group_any","- user group -");
$this->set("select.xyo_module_group_any","- module group -");

$this->set("label.xyo_module_id","Module");
$this->set("select.xyo_module_any","- module -");
$this->set("label.xyo_module_group_id","Module group");
$this->set("select.xyo_module_group_any","- group -");
$this->set("label.order","Order");

$this->set("label.xyo_user_group_id","User group");
$this->set("label.xyo_core_id","Core");

$this->set("info.version","Version");
$this->set("info.author","By");
$this->set("info.site","Website");
$this->set("info.license","License");
