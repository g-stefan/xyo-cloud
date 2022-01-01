<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
