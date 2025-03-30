<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_Application";

class xyo_mod_Application extends xyo_Module {

	protected $user;
	protected $accessControlList;
	protected $cloudSettings;
	protected $moduleSettings;
	protected $userSettings;

	protected $applicationDataSource;

	protected $ds;
	protected $isNew;
	protected $primaryKey;
	protected $primaryKeyValue;

	protected $applicationTitle;
	protected $applicationIcon;

        protected $isDialog;
        protected $isInline;	

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isOk) {

			$this->cloudSettings = &$this->cloud->getModule("xyo-mod-ds-settings");
			$this->moduleSettings = &$this->cloud->getModule("xyo-mod-ds-module-settings");
			$this->userSettings = &$this->cloud->getModule("xyo-mod-ds-user-settings");
			$this->accessControlList = &$this->cloud->getModule("xyo-mod-ds-acl");
			$this->user = &$this->cloud->getModule("xyo-mod-ds-user");

			if (!($this->accessControlList && $this->user)) {
				$this->moduleDisable();
			};

			$this->loadLanguage();

			$this->ds = null;
			$this->isNew = true;
			$this->primaryKeyValue = null;
			$this->primaryKey = "_unknown_";
			$this->applicationDataSource=null;

		        $this->applicationIcon = "<i class=\"lucide-extension\"></i>";
			$this->applicationTitle = null;
			
			$this->isDialog = false;
			$this->isInline = false;
		};
	}

	public function moduleMain() {
		$this->isDialog=$this->getParameterRequest("dialog",$this->isDialog);
		$this->isInline=$this->getParameterRequest("inline",$this->isInline);
		$this->setFormName($this->getParameter("form_name","fn"));
		parent::moduleMain();
	}

	public function setApplicationDataSource($name) {
		$this->applicationDataSource=$name;
	}

	public function setDs() {
		$this->ds = &$this->getDataSource($this->applicationDataSource);
		if ($this->ds) {
			return true;
		};
		return false;
	}

	public function setPrimaryKey($value_) {
		$this->primaryKey=$value_;
	}

	public function setPrimaryKeyValue($value_) {
		if(is_null($value_)){
			return false;
		};
		if(strlen($value_)==0){
			return false;
		};
		$primaryKeyValue_ = explode(",", $value_);
		$c=count($primaryKeyValue_);
		if ($c) {
			if($c==1) {
				$this->primaryKeyValue=$primaryKeyValue_[0];
			} else {
				$this->primaryKeyValue=array();
				foreach ($primaryKeyValue_ as $value) {
					if(strlen(trim($value))==0){
						continue;
					};
					$this->primaryKeyValue[]=$value;
				}
				$this->primaryKeyValue=array_unique($this->primaryKeyValue);
			}
			return true;
		}
		return false;
	}

	public function setPrimaryKeyValueOne($value_) {
		if(is_null($value_)){
			return false;
		};
		if(strlen($value_)==0){
			return false;
		};
		$primaryKeyValue_ = explode(",", $value_);
		$c=count($primaryKeyValue_);
		if ($c) {
			$this->primaryKeyValue=$primaryKeyValue_[0];
			return true;
		}
		return false;
	}

	public function getPrimaryKeyValueOne($value_) {
		if(is_null($value_)){
			return 0;
		};
		if(strlen($value_)==0){
			return 0;
		};
		$primaryKeyValue_ = explode(",", $value_);
		$c=count($primaryKeyValue_);
		if ($c) {
			return $primaryKeyValue_[0];
		};
		return 0;
	}

	public function setApplicationIcon($icon) {
		$this->applicationIcon = $icon;
	}

	public function getApplicationIcon() {
		return $this->applicationIcon;
	}

	public function setApplicationTitle($title) {
		$this->applicationTitle = $title;
	}

	public function getApplicationTitle() {
		return $this->applicationTitle;
	}

	public function setIsDialog($value) {
		$this->isDialog=$value;
	}

	public function getIsDialog() {
		return $this->isDialog;
	}

	public function setIsInline($value) {
		$this->isInline=$value;
	}

	public function getIsInline() {
		return $this->isInline;
	}

	public function formatDateTime($value,$format=null) {
		if(is_null($format)){
			$format=$this->cloud->get("locale_date_format","");
		};

		if($format=="Y-m-d"){
			return substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2)." ".substr($value,11);
		};

		if($format=="Y/m/d"){
			return substr($value,0,4)."/".substr($value,5,2)."/".substr($value,8,2)." ".substr($value,11); 
		};

		if($format=="d-m-Y"){
			return substr($value,8,2)."-".substr($value,5,2)."-".substr($value,0,4)." ".substr($value,11); 
		};
		
		if($format=="d/m/Y"){
			return substr($value,8,2)."/".substr($value,5,2)."/".substr($value,0,4)." ".substr($value,11); 
		};

		return $value;		
	}

	public function formatDate($value,$format=null) {
		if(is_null($format)){
			$format=$this->cloud->get("locale_date_format","");
		};

		if($format=="Y-m-d"){
			return substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2);
		};

		if($format=="Y/m/d"){
			return substr($value,0,4)."/".substr($value,5,2)."/".substr($value,8,2); 
		};

		if($format=="d-m-Y"){
			return substr($value,8,2)."-".substr($value,5,2)."-".substr($value,0,4); 
		};
		
		if($format=="d/m/Y"){
			return substr($value,8,2)."/".substr($value,5,2)."/".substr($value,0,4); 
		};

		return $value;		
	}

	public function formatDateTimeNoSeconds($value,$format=null) {
		if(is_null($format)){
			$format=$this->cloud->get("locale_date_format","");
		};

		if($format=="Y-m-d"){
			return substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2)." ".substr($value,11,5);
		};

		if($format=="Y/m/d"){
			return substr($value,0,4)."/".substr($value,5,2)."/".substr($value,8,2)." ".substr($value,11,5); 
		};

		if($format=="d-m-Y"){
			return substr($value,8,2)."-".substr($value,5,2)."-".substr($value,0,4)." ".substr($value,11,5); 
		};
		
		if($format=="d/m/Y"){
			return substr($value,8,2)."/".substr($value,5,2)."/".substr($value,0,4)." ".substr($value,11,5); 
		};

		return $value;		
	}

	public function dsPrimaryKeyLoad() {
		$this->ds->clear();
		if (!$this->isNew) {
			$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
			if (!$this->ds->load(0, 1)) {
				$this->setError(array("error.not_found" => $this->primaryKeyValue));
				return false;
			};
		};
		return true;
	}

	public function elementValueStringIsEmpty($element) {
		if (strlen($this->getElementValueString($element)) == 0) {
			$this->setElementErrorFromLanguage($element, "is_empty");
			return true;
		};
		return false;
	}

	public function elementValueNumberIsZero($element) {
		if ($this->getElementValueNumber($element) == 0) {
			$this->setElementErrorFromLanguage($element, "is_zero");
			return true;
		};
		return false;
	}

	public function dsElementValueStringExists($element) {
		$this->ds->clear();
		$this->ds->{$element} = $this->getElementValueString($element);
		if ($this->ds->load(0, 1)) {
			if ($this->isNew) {
				$this->setElementErrorFromLanguage($element, "already_exists");
				return true;
			};
			if ($this->ds->{$this->primaryKey} != $this->primaryKeyValue) {
				$this->setElementErrorFromLanguage($element, "already_exists");
				return true;
			};
		};
		return false;
	}

	public function dsElementValueNumberExists($element) {
		$this->ds->clear();
		$this->ds->{$element} = $this->getElementValueNumber($element);
		if ($this->ds->load(0, 1)) {
			if ($this->isNew) {
				$this->setElementErrorFromLanguage($element, "already_exists");
				return true;
			};
			if ($this->ds->{$this->primaryKey} != $this->primaryKeyValue) {
				$this->setElementErrorFromLanguage($element, "already_exists");
				return true;
			};
		};
		return false;
	}

	public function getCloudSetting($name, $default=null) {
		return $this->cloudSettings->getSetting($name, $default);
	}

	public function setCloudSetting($name, $value) {
		return $this->cloudSettings->setSetting($name, $value);
	}

	public function getCloudSettingsList(&$settings) {
		return $this->cloudSettings->getSettingsList($settings);
	}

	public function setCloudSettingsList(&$settings) {
		return $this->cloudSettings->setSettingsList($settings);
	}

	public function getModuleSetting($name, $default=null) {
		return $this->moduleSettings->getSetting($this->name, $name, $default);
	}

	public function setModuleSetting($name, $value) {
		return $this->moduleSettings->setSetting($this->name, $name, $value);
	}

	public function getModuleSettingsList(&$settings) {
		return $this->moduleSettings->getSettingsList($this->name, $settings);
	}

	public function setModuleSettingsList(&$settings) {
		return $this->moduleSettings->setSettingsList($this->name, $settings);
	}

	public function getUserSetting($name, $default=null) {
		return $this->userSettings->getSetting($name, $default);
	}

	public function setUserSetting($name, $value) {
		return $this->userSettings->setSetting($name, $value);
	}

	public function getUserSettingsList(&$settings) {
		return $this->userSettings->getSettingsList($settings);
	}

	public function setUserSettingsList(&$settings) {
		return $this->userSettings->setSettingsList($settings);
	}

	public function getUserModuleSetting($name, $default=null) {
		return $this->userSettings->getModuleSetting($this->name, $name, $default);
	}

	public function setUserModuleSetting($name, $value) {
		return $this->userSettings->setModuleSetting($this->name, $name, $value);
	}

	public function getUserModuleSettingsList(&$settings) {
		return $this->userSettings->getModuleSettingsList($this->name, $settings);
	}

	public function setUserModuleSettingsList(&$settings) {
		return $this->userSettings->setModuleSettingsList($this->name, $settings);
	}

	public function hasSearch() {
		return false;
	}

}

