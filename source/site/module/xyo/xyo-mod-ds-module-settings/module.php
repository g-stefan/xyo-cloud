<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_ds_ModuleSettings";

class xyo_mod_ds_ModuleSettings extends xyo_Module {
	
	var $dsSettings;
	var $dsModule;
	
	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		
		$this->dsSettings=&$this->getDataSource("db.table.xyo_module_settings");
		$this->dsModule=&$this->getDataSource("db.table.xyo_module");
	}

	public function getSetting($module, $name, $default=null) {
		$this->dsModule->clear();
		$this->dsModule->name=$module;
		if($this->dsModule->load(0,1)) {
			$this->dsSettings->clear();
			$this->dsSettings->xyo_module_id=$this->dsModule->id;
			$this->dsSettings->name=$name;
			if($this->dsSettings->load(0,1)) {
				return $this->dsSettings->value;
			};
		};
		return $default;
	}

	public function setSetting($module, $name, $value) {
		$this->dsModule->clear();
		$this->dsModule->name=$module;
		if($this->dsModule->load(0,1)) {
			$this->dsSettings->clear();
			$this->dsSettings->xyo_module_id=$this->dsModule->id;
			$this->dsSettings->name=$name;
			$this->dsSettings->tryLoad(0,1);
			$this->dsSettings->value=$value;
			return $this->dsSettings->save();
		};
		return false;
	}

	public function getSettingsList($module, &$settings) {
		$this->dsModule->clear();
		$this->dsModule->name=$module;
		if($this->dsModule->load(0,1)) {
			$this->dsSettings->clear();
			$this->dsSettings->xyo_module_id=$this->dsModule->id;
			$this->dsSettings->name=array_keys($settings);
			for($this->dsSettings->load(0,count($settings));$this->dsSettings->isValid();$this->dsSettings->loadNext()) {
				$settings[$this->dsSettings->name]=$this->dsSettings->value;
			};		
		};
	}

	public function setSettingsList($module, &$settings) {
		foreach($settings as $name=>$value) {
			setSetting($module, $name, $value);
		};		
	}
	
}
