<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if($this->xyo_module_id>0) {

	foreach($this->items as $item) {
		if($item["type"]=="select"){
			$this->generateComponent($item["type"],array("element" =>$item["name"]));
		}else{
			$this->generateComponent($item["type"],array_merge(array("element" =>$item["name"]),$item["parameters"]));
		};
	};

};

