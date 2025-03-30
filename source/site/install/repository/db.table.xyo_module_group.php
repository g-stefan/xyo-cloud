<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$module_group = &$dataSource;

$listModuleGroup=array(
	"none",
	"system-init",
	"system-load",
	"system-run",
	"sidebar",
	"dashboard",
	"control-panel",
	"about",
	"status",
	"user",
	"template"
);

foreach($listModuleGroup as $name){
	$module_group->clear();
	$module_group->name = $name;
	$module_group->tryLoad();
	$module_group->enabled = 1;
	$module_group->save();
};
