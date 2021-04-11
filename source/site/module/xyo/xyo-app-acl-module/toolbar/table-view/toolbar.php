<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if($this->isRequestCall()){
	$this->setItem("separator-done","separator",null,null,null,null,null);

	$this->setItem("done",
        	"item-js",
	        "<i class=\"material-icons\">done</i>",
        	"done",
	        "info",
        	"#",
		$this->instanceV."doReturn();"
	);
};
