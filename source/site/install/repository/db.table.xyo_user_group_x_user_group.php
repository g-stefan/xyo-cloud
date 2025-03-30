<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$dsUserGroupXUserGroup = &$dataSource;

$dsUserGroupX = &$this->getDataSource("db.table.xyo_user_group");
$dsUserGroupY = &$this->getDataSource("db.table.xyo_user_group");

$dsUserGroupX->clear();
$dsUserGroupX->name = "administrator";
$dsUserGroupX->enabled = 1;
if ($dsUserGroupX->load(0, 1)) {

	$dsUserGroupY->clear();
	$dsUserGroupY->name = "authenticated";
	$dsUserGroupY->enabled = 1;
	if ($dsUserGroupY->load(0, 1)) {


		$dsUserGroupXUserGroup->clear();
		$dsUserGroupXUserGroup->xyo_user_group_id_super = $dsUserGroupX->id;
		$dsUserGroupXUserGroup->xyo_user_group_id = $dsUserGroupY->id;
		$dsUserGroupXUserGroup->tryLoad();
		$dsUserGroupXUserGroup->enabled = 1;
		$dsUserGroupXUserGroup->save();

	};
};

$dsUserGroupX->clear();
$dsUserGroupX->name = "wheel";
$dsUserGroupX->enabled = 1;
if ($dsUserGroupX->load(0, 1)) {


	$dsUserGroupY->clear();
	$dsUserGroupY->name = "authenticated";
	$dsUserGroupY->enabled = 1;
	if ($dsUserGroupY->load(0, 1)) {


		$dsUserGroupXUserGroup->clear();
		$dsUserGroupXUserGroup->xyo_user_group_id_super = $dsUserGroupX->id;
		$dsUserGroupXUserGroup->xyo_user_group_id = $dsUserGroupY->id;
		$dsUserGroupXUserGroup->tryLoad();
		$dsUserGroupXUserGroup->enabled = 1;
		$dsUserGroupXUserGroup->save();

	};

	$dsUserGroupY->clear();
	$dsUserGroupY->name = "administrator";
	$dsUserGroupY->enabled = 1;
	if ($dsUserGroupY->load(0, 1)) {


		$dsUserGroupXUserGroup->clear();
		$dsUserGroupXUserGroup->xyo_user_group_id_super = $dsUserGroupX->id;
		$dsUserGroupXUserGroup->xyo_user_group_id = $dsUserGroupY->id;
		$dsUserGroupXUserGroup->tryLoad();
		$dsUserGroupXUserGroup->enabled = 1;
		$dsUserGroupXUserGroup->save();

	};
};

