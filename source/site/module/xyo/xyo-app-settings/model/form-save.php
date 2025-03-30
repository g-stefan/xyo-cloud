<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

foreach($this->items as $item) {
	if(!is_null($item["name"])){
		$this->processComponent($item["type"],array_merge(array("element" =>$item["name"]),$item["parameters"]));
		$this->ds->clear();
		$this->ds->name=$item["name"];
		$this->ds->tryLoad(0,1);		
		$this->ds->value=$this->getElementValueString($item["name"],$item["default_value"]);
		$this->ds->save();		
	};
};
