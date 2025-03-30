<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->eGenerateCallRequest(
	array("action"=>"table-view"),
	"xyo-app-acl-module",
	array("xyo_module_group_id"=>0),
	"xyo_module_group_id",
	"callModuleAcl"
);
