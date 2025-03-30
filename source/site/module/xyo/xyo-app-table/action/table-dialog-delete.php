<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->tableIsDelete=true;
$this->isDialog=true;
$this->processModel("set-primary-key-value");
$this->processModel("table-view");
$this->processModel("table-view-process");
$this->setViewTemplate(null);
$this->setView("table-dialog-delete");
