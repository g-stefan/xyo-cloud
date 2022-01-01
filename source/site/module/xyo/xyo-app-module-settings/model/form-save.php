<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if($this->xyo_module_id>0) {

	foreach($this->items as $item) {
		if(!is_null($item["name"])){
			$this->processComponent($item["type"],array_merge(array("element" =>$item["name"]),$item["parameters"]));
			$this->ds->clear();
			$this->ds->xyo_module_id=$this->xyo_module_id;
			$this->ds->name=$item["name"];
			$this->ds->tryLoad(0,1);		
			$this->ds->value=$this->getElementValueString($item["name"],$item["default_value"]);
			$this->ds->save();		
		};
	};
		
};
