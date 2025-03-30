<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title","Subgroups of users");

$this->set("head.user_group_super","Super group");
$this->set("head.user_group","Group");
$this->set("head.id","Id");

$this->set("label.xyo_user_group_id_super","Super group");
$this->set("label.xyo_user_group_id","Group");

$this->set("select.xyo_user_group_super_any","- super group -");
$this->set("select.xyo_user_group_any","- group -");

$this->set("search_user_group_super","Super group");
$this->set("search_user_group","Group");

$this->set("select.xyo_user_group_any_edit","- none -");
