<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "User groups");
$this->set("application.title_embedded", "Groups");

$this->set("head.name", "User");
$this->set("head.user_group", "Group");
$this->set("head.principal", "Principal");
$this->set("head.enabled", "Enabled");
$this->set("head.id", "Id");

$this->set("select.xyo_user_any", "- user -");
$this->set("select.xyo_user_group_any", "- user group -");

$this->set("label.xyo_user_id", "User");
$this->set("label.xyo_user_group_id", "User group");
$this->set("label.principal", "Principal");

$this->set("select.xyo_user_group_none","- none -");
