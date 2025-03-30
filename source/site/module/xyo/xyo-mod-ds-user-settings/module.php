<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_ds_UserSettings";

class xyo_mod_ds_UserSettings extends xyo_Module {
	
	var $dsSettings;
	var $dsModule;
	var $dsUserXModuleSettings;
	var $modUser;	
	
	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		
		$this->dsSettings=&$this->getDataSource("db.table.xyo_user_settings");
		$this->dsModule=&$this->getDataSource("db.table.xyo_module");
		$this->dsUserXModuleSettings=&$this->getDataSource("db.table.xyo_user_x_module_settings");
		$this->modUser=&$this->getModule("xyo-mod-ds-user");
	}

	public function getSetting($name, $default=null) {
		if($this->modUser->info->id==0) {
			return $default;
		};
		$this->dsSettings->clear();
		$this->dsSettings->xyo_user_id=$this->modUser->info->id;
		$this->dsSettings->name=$name;
		if($this->dsSettings->load(0,1)){
			return $this->dsSettings->value;
		};
		return $default;
	}

	public function setSetting($name, $value) {
		if($this->modUser->info->id==0) {
			return $default;
		};
		$this->dsSettings->clear();
		$this->dsSettings->xyo_user_id=$this->modUser->info->id;
		$this->dsSettings->name=$name;
		$this->dsSettings->tryLoad(0,1);
		$this->dsSettings->value=$value;
		return $this->dsSettings->save();
	}

	public function getSettingsList(&$settings) {		
		if($this->modUser->info->id==0) {
			return $default;
		};
		$this->dsSettings->clear();
		$this->dsSettings->xyo_user_id=$this->modUser->info->id;
		$this->dsSettings->name=array_keys($settings);
		for($this->dsSettings->load(0,count($settings));$this->dsSettings->isValid();$this->dsSettings->loadNext()) {
			$settings[$this->dsSettings->name]=$this->dsSettings->value;
		};		
	}

	public function setSettingsList(&$settings) {
		if($this->modUser->info->id==0) {
			return $default;
		};
		foreach($settings as $name=>$value) {
			setSetting($name, $value);
		};		
	}
	
	public function getModuleSetting($module, $name, $default=null) {
		if($this->modUser->info->id==0) {
			return $default;
		};
		$this->dsModule->clear();
		$this->dsModule->name=$module;
		if($this->dsModule->load(0,1)) {
			$this->dsUserXModuleSettings->clear();
			$this->dsUserXModuleSettings->xyo_module_id=$this->dsModule->id;
			$this->dsUserXModuleSettings->xyo_user_id=$this->modUser->info->id;
			$this->dsUserXModuleSettings->name=$name;
			if($this->dsUserXModuleSettings->load(0,1)){
				return $this->dsUserXModuleSettings->value;
			};
			return $default;
		};
		return $default;
	}

	public function setModuleSetting($module, $name, $value) {
		if($this->modUser->info->id==0) {
			return $default;
		};
		$this->dsModule->clear();
		$this->dsModule->name=$module;
		if($this->dsModule->load(0,1)) {
			$this->dsUserXModuleSettings->clear();
			$this->dsUserXModuleSettings->xyo_module_id=$this->dsModule->id;
			$this->dsUserXModuleSettings->xyo_user_id=$this->modUser->info->id;
			$this->dsUserXModuleSettings->name=$name;
			$this->dsUserXModuleSettings->tryLoad(0,1);
			$this->dsUserXModuleSettings->value=$value;
			return $this->dsUserXModuleSettings->save();
		};
		return false;
	}

	public function getModuleSettingsList($module, &$settings) {
		if($this->modUser->info->id==0) {
			return $default;
		};
		$this->dsModule->clear();
		$this->dsModule->name=$module;
		if($this->dsModule->load(0,1)) {
			$this->dsUserXModuleSettings->clear();
			$this->dsUserXModuleSettings->xyo_module_id=$this->dsModule->id;
			$this->dsUserXModuleSettings->xyo_user_id=$this->modUser->info->id;
			$this->dsUserXModuleSettings->name=array_keys($settings);
			for($this->dsUserXModuleSettings->load(0,count($settings));$this->dsUserXModuleSettings->isValid();$this->dsUserXModuleSettings->loadNext()) {
				$settings[$this->dsUserXModuleSettings->name]=$this->dsUserXModuleSettings->value;
			};
		};
	}

	public function setModuleSettingsList($module, &$settings) {
		if($this->modUser->info->id==0) {
			return $default;
		};
		foreach($settings as $name=>$value) {
			setModuleSetting($name, $value);
		};		
	}
}
