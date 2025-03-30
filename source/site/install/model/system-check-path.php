<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$path = array(
	"lib" => "lib",
	"config" => "config",
	"repository" => "repository",
	"package" => "package",
	"module" => "module",
	"datasource" => "datasource",
	"component" => "component",
	"log" => "log",
	"temp" => "temp"
);

$path_ = array();
foreach ($path as $key => $value) {
	if (is_writable($value)) {
		$path_[$key] = "yes";
	} else {
		$path_[$key] = "no";
	};
};

$this->setParameter("path", $path_);
