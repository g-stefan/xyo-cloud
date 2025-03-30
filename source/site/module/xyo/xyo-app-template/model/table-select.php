<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ds->module_group_name="template";

$this->ds->setGroup("id",true);
$this->ds->setGroup("module_name",true);
$this->ds->setGroup("module_group_name",true);
$this->ds->setGroup("user_group_name",true);
$this->ds->setGroup("core_name",true);
