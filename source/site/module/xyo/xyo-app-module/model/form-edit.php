<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->processModel("select-enabled-edit");

if($this->isNew) {
	$this->processModel("select-acl-enabled-edit");
	$this->processModel("select-xyo-module-group-edit");
	$this->processModel("select-xyo-core-edit");
	$this->processModel("select-xyo-user-group-edit");
};
