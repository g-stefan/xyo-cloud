<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Grupuri utilizator");
$this->set("application.title_embedded", "Grupuri");

$this->set("head.name", "Utilizator");
$this->set("head.user_group", "Grup");
$this->set("head.principal", "Principal");
$this->set("head.enabled", "Activat");
$this->set("head.id", "Id");

$this->set("select.xyo_user_any", "- utilizator -");
$this->set("select.xyo_user_group_any", "- grup utilizator -");

$this->set("label.xyo_user_id", "Utilizator");
$this->set("label.xyo_user_group_id", "Grup utilizator");
$this->set("label.principal", "Principal");

$this->set("select.xyo_user_group_none","- nici unul -");
