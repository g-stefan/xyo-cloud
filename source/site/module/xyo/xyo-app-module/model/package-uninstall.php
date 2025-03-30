<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ds->clear();
$this->ds-> {$this->primaryKey} = $this->primaryKeyValue;
for ($this->ds->load(); $this->ds->isValid(); $this->ds->loadNext()) {

	$this->processModel("package-uninstall-cmd");

	if ($this->isError()) {
		break;
	};
};

if (!$this->isError()) {
	$this->setAlert("info.package_uninstall_ok");
};

