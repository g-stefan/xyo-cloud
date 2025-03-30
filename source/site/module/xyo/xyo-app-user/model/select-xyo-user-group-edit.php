<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$userGroup = array();
$userGroup["*"] = $this->getFromLanguage("select.xyo_user_group_none");
$dsUserGroup = &$this->getDataSource("db.table.xyo_user_group");
if ($dsUserGroup) {
	$dsUserGroup->clear();
	$dsUserGroup->setOrder("name",1);
	if(!$this->user->isInGroup("wheel")){	
		$dsUserGroup->pushOperator("and");
		$dsUserGroup->setOperator("name","!=","wheel",null,false,false);	
	};
	for ($dsUserGroup->load(); $dsUserGroup->isValid(); $dsUserGroup->loadNext()) {
		$userGroup[$dsUserGroup->id] = $dsUserGroup->name;
	};
};

$this->setParameter("select.xyo_user_group_id",$userGroup);
