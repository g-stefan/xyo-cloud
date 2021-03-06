<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setItem("apply",
	"item-js",
	"<i class=\"material-icons\">save_alt</i>",
	"apply",
	"success",
	"#",
	$this->instanceV."doCommand('form-edit-apply');"
);

if($this->isRequestCall()){
	$this->setItem("done",
		"item-js",
		"<i class=\"material-icons\">done</i>",
		"done",
		"info",
		"#",
		$this->instanceV."doReturn();"
	);
};
