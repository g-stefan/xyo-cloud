<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->isNew = false;
$this->setParameter("toolbar", "toolbar/form-edit");
$this->processModel("set-ds");
$this->processModel("form-edit");
$this->setView("form-edit");
