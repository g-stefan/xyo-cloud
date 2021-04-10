<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->eGenerateCallRequest(
	array("action"=>"table-view"),
	"xyo-app-module-settings",
	array("xyo_acl_module_id"=>0),
	"xyo_acl_module_id",
	"callModuleSettings"
);

$this->eGenerateCallRequest(
	array("action"=>"table-view"),
	"xyo-app-acl-module",
	array("xyo_acl_module_id"=>0),
	"xyo_acl_module_id",
	"callModuleAcl"
);
