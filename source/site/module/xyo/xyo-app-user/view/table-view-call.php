<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->eGenerateCallRequest(
	array("action"=>"table-view"),
	"xyo-app-user-x-user-group",
	array("xyo_user_id"=>0),
	"xyo_user_id",
	"callUserXUserGroup"
);

$dsModule = &$this->getDataSource("db.table.xyo_module");
$dsModule->clear();
$dsModule->name = $this->name;
if($dsModule->load(0,1)) {
	$this->eGenerateCallRequestJs(
		array("action"=>"form-edit"),
		"xyo-app-module-settings-x-user",
		array("xyo_module_id"=>$dsModule->id),
		"callAppSettings",
		"function(form_){return true;}"
	);
};
