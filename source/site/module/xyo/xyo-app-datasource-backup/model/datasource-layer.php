<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$layer = $this->getParameterRequest("layer", null);
$fileName = "config/config.ds.backup.php";
$moduleName = "";
if ($layer === "xyo") {
	$moduleName = "xyo-datasource-xyo";
} else
if ($layer === "csv") {
	$moduleName = "xyo-datasource-csv";
} else
if ($layer === "mysql") {
	$moduleName = "xyo-datasource-mysql";
} else
if ($layer === "mysqli") {
	$moduleName = "xyo-datasource-mysqli";
} else
if ($layer === "postgresql") {
	$moduleName = "xyo-datasource-postgresql";
} else
if ($layer === "sqlite") {
	$moduleName = "xyo-datasource-sqlite";
} else {
	$this->setError(array("error.unknown_layer" => $layer));
	return;
};

$this->setParameter("layer_module", $moduleName);
$this->setParameter("layer_config", $fileName);
