<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_app_Settings";

class xyo_app_Settings extends xyo_app_Application {

	protected $items; 
	protected $elements; 	

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		$this->items=array();
		$this->elements=array();
	}

	public function addItem($type, $name=null, $defaultValue=null, $parameters=null) {
		$this->requireComponent(array($type));
		$item = array();
		$item["type"] = $type;
		$item["name"] = $name;
		$item["default_value"] = $defaultValue;
		if(is_null($parameters)){
			$parameters=array();
		};
		$item["parameters"]=$parameters;
		$this->items[] = &$item;
		$this->elements[$type]=$type;
	}

}
