<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_ds_Settings";

class xyo_mod_ds_Settings extends xyo_Module {
	
	var $dsSettings;	
	
	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		
		$this->dsSettings=&$this->getDataSource("db.table.xyo_settings");		
	}

	public function getSetting($name, $default=null) {
		$this->dsSettings->clear();
		$this->dsSettings->name=$name;
		if($this->dsSettings->load(0,1)){
			return $this->dsSettings->value;
		};
		return $default;
	}

	public function setSetting($name, $value) {
		$this->dsSettings->clear();
		$this->dsSettings->name=$name;
		$this->dsSettings->tryLoad(0,1);
		$this->dsSettings->value=$value;
		return $this->dsSettings->save();
	}

	public function getSettingsList(&$settings) {
		$this->dsSettings->clear();
		$this->dsSettings->name=array_keys($settings);
		for($this->dsSettings->load(0,count($settings));$this->dsSettings->isValid();$this->dsSettings->loadNext()) {
			$settings[$this->dsSettings->name]=$this->dsSettings->value;
		};		
	}

	public function setSettingsList(&$settings) {
		foreach($settings as $name=>$value) {
			setSetting($name, $value);
		};		
	}
	
}
