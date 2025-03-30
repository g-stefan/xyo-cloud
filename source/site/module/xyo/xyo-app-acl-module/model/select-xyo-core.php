<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$listCore = array();
$listCore["*"] = $this->getFromLanguage("select.xyo_core_any");
$dsCore = &$this->getDataSource("db.table.xyo_core");
if ($dsCore) {
	$dsCore->clear();
	$dsCore->setOrder("name",1);
	for ($dsCore->load(); $dsCore->isValid(); $dsCore->loadNext()) {
		$listCore[$dsCore->id] = $dsCore->name;
	};
};

$this->setParameter("select.xyo_core_id", $listCore);
