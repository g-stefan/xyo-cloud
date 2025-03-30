<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if($this->isRequestCall()){
	$this->setItem("done",
        	"item-js",
	        "<i class=\"lucide-check\"></i>",
        	"done",
	        "info",
        	"#",
		$this->instanceV."doReturn();"
	);
}else{
	$this->setItem("done",
	        "item-js",
        	"<i class=\"lucide-check\"></i>",
	        "done",
        	"info",
	        "#",
		$this->instanceV."doCommand('default');"
	);
};

