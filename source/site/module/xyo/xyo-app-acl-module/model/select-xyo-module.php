<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$listModule = array();
$listModule["*"] = $this->getFromLanguage("select.xyo_module_any");
$dsModule = &$this->getDataSource("db.table.xyo_module");
if ($dsModule) {
	$dsModule->clear();
	$dsModule->setOrder("name",1);
	for ($dsModule->load(); $dsModule->isValid(); $dsModule->loadNext()) {
		$listModule[$dsModule->id] = $dsModule->name;
    	};
};

$this->setParameter("select.xyo_module_id", $listModule);
