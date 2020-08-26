<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$dsAclModule = &$this->getDataSource("db.table.xyo_acl_module");
$dsModuleParameter = &$this->getDataSource("db.table.xyo_module_parameter");
$dsModule = &$this->getDataSource("db.table.xyo_module");
$dsFormElement = &$this->getDataSource("db.table.xyo_form_element");

$this->ds->clear();
$this->ds-> {$this->primaryKey} = $this->primaryKeyValue;
for ($this->ds->load(); $this->ds->isValid(); $this->ds->loadNext()) {
	if($dsFormElement) {
		$dsFormElement->clear();
		$dsAclModule->xyo_module_id = $this->ds->id;
		$dsAclModule->delete();
	};
	if ($dsAclModule) {
		$dsAclModule->clear();
		$dsAclModule->xyo_module_id = $this->ds->id;
		$dsAclModule->delete();
	};
	if ($dsModuleParameter) {
		$dsModuleParameter->clear();
		$dsModuleParameter->xyo_module_id = $this->ds->id;
		$dsModuleParameter->delete();
	};
	$this->ds->delete();
};

$this->setAlert("info.delete_ok");
