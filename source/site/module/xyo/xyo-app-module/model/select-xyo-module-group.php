<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$listModuleGroup = array();
$listModuleGroup["*"] = $this->getFromLanguage("select.xyo_module_group_any");
$dsModuleGroup = &$this->getDataSource("db.table.xyo_module_group");
if ($dsModuleGroup) {
	$dsModuleGroup->clear();
	$dsModuleGroup->setOrder("name",1);
	for ($dsModuleGroup->load(); $dsModuleGroup->isValid(); $dsModuleGroup->loadNext()) {
		$listModuleGroup[$dsModuleGroup->id] = $dsModuleGroup->name;
	};
};

$this->setParameter("select.xyo_module_group_id", $listModuleGroup);
