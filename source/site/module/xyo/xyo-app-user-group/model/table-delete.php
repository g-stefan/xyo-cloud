<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$dsAclModule = &$this->getDataSource("db.table.xyo_acl_module");
$dsAclModuleParameter = &$this->getDataSource("db.table.xyo_acl_module_parameter");
$dsAclProperty = &$this->getDataSource("db.table.xyo_acl_property");
$dsUserGroupXUsergroup = &$this->getDataSource("db.table.xyo_user_group_x_user_group");
$dsUserXUserGroup = &$this->getDataSource("db.table.xyo_user_x_user_group");

$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;

for ($this->ds->load(); $this->ds->isValid(); $this->ds->loadNext()) {
	if ($dsAclModule) {
		$dsAclModule->clear();
		$dsAclModule->xyo_user_group_id = $this->ds->id;
		$dsAclModule->delete();
	};
	if ($dsAclModuleParameter) {
		$dsAclModuleParameter->clear();
		$dsAclModuleParameter->xyo_user_group_id = $this->ds->id;
		 $dsAclModuleParameter->delete();
	};
	if ($dsAclProperty) {
		$dsAclProperty->clear();
		$dsAclProperty->xyo_user_group_id = $this->ds->id;
		$dsAclProperty->delete();
	};
	if ($dsUserGroupXUserGroup) {
		$dsUserGroupXUserGroup->clear();
		$dsUserGroupXUserGroup->xyo_user_group_id = $this->ds->id;
		$dsUserGroupXUserGroup->delete();
	};
	if ($dsUserXUserGroup) {
		$dsUserXUserGroup->clear();
		$dsUserXUserGroup->xyo_user_group_id = $this->ds->id;
		$dsUserXUserGroup->delete();
	};
	$this->ds->delete();
};

$this->setAlert("info.delete_ok");
