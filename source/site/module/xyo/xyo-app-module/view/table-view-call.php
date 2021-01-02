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
	"xyo-app-acl-module",
	array("xyo_module_id"=>0),
	"xyo_module_id",
	"callModuleAcl"
);

$this->eGenerateCallRequest(
	array("action"=>"table-view"),
	"xyo-app-module-parameter",
	array("xyo_module_id"=>0),
	"xyo_module_id",
	"callModuleParameter"
);

$this->eGenerateCallRequest(
	array("action"=>"table-view"),
	"xyo-app-form-element",
	array("xyo_module_id"=>0),
	"xyo_module_id",
	"callFormElement"
);
