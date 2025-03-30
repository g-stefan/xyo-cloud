<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->isInline=true;
$this->setFormName($this->getFormName()."_new");
$this->doActionBase("form-new");
$this->setViewTemplate(null);
$this->setView("table-inline-new");
