<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_app_ModuleSettings";

class xyo_app_ModuleSettings extends xyo_app_Application {

	protected $xyo_module_id;
	protected $items; 
	protected $elements; 	

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		$this->xyo_module_id=0;
		$this->items=array();
		$this->elements=array();
	}

	public function addModule($module) {
		$pathList = $this->cloud->getModulePathBase($module);
		if(!is_array($pathList)){
			$pathList=array($module=>$this->cloud->getModulePath($module));
		};
		foreach($pathList as $path) {
			$this->loadLanguageFromPathDirect($path . "sys/language/", $this->getSystemLanguage());
			$file = $path . "sys/settings.php";
			if (file_exists($file)) {
				include($file);
				return;
           		};
		};
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
