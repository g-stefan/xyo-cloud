<?php
// Copyright (c) 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"material-icons\">settings_applications</i>");
$this->setApplicationDataSource("db.table.xyo_settings");

$this->setDefaultAction($this->getRequest("action", "form-edit"));
