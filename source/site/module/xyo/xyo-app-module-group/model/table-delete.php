<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$dsAclModule = &$this->getDataSource("db.table.xyo_acl_module");

$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;

for ($this->ds->load(); $this->ds->isValid(); $this->ds->loadNext()) {
	if ($dsAclModule) {
		$dsAclModule->clear();
		$dsAclModule->xyo_module_group_id = $this->ds->id;
		$dsAclModule->delete();
	};
	$this->ds->delete();
};

$this->setAlert("info.delete_ok");
