<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->eGenerateCallRequestJs(
	array("action"=>"table-view"),
	"xyo-app-datasource-backup",
	null,
	"callDatasourceBackup",
	"function(e){return true;}"
);
