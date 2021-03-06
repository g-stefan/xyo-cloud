<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_xui_User";

class xyo_mod_xui_User extends xyo_mod_Application {

	protected $menu;
	protected $groupSp_;
	protected $group_;

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
	}

	public function getMenu(){
		return $this->menu;
	}

	public function initGroup($group) {
		$this->menu = array();
		$this->groupSp_= array();
		$this->group_= null;
		if ($group) {
			$this->addGroup($this->menu, $group);
        	};
	}

	public function addGroup(&$menu, $name) {
		$list = &$this->cloud->getGroup($name);
		if (count($list)) {
			array_push($this->groupSp_,$this->group_);
			$this->group_=$name;

			foreach ($list as $value) {
				$this->addModule($menu, $value);
			};

			$this->group_=array_pop($this->groupSp_);
        	};
	}

	public function addModule(&$menu, $module) {
		$path = $this->cloud->getModulePath($module);
		if ($path) {
			$this->loadLanguageFromPathDirect($path . "sys/language/",$this->getSystemLanguage());
			$file = $path . "sys/user.php";
			if (file_exists($file)) {
				include($file);
			} else {
				$this->addItem($menu, "item", null, $module, $module, null);
			};
		};
	}

	public function &addItem(&$menu, $type, $icon, $title, $module, $parameters=null, $iconActive=null) {
	        $item = array();

		$item["icon"]=$icon;

		if($this->isApplication($module)){
			if($type==="item"){
				$type="item-activated";
			};
			if($type==="item-hidden"){
				$type="item-hidden-activated";
			};
		        $item["active"] = true;

			if($iconActive){
				$item["icon"]=$iconActive;
			};
		};

	        $item["type"] = $type;
		if($item["type"]=="separator"){
			$item["separator"]=true;
		};
		if($item["type"]=="separator-begin"){
			$item["separator"]=true;
		};
		if($item["type"]=="separator-end"){
			$item["separator"]=true;
		};
	
		if($title){
		        $item["text"] = $this->getFromlanguage($title);
		}else{
			$item["text"] = "";
		};

	        $item["url"] = $this->cloud->requestUriModule($module, $parameters);        
	        $item["popup"] = array();
	        $menu[] = &$item;
	        return $item["popup"];
	}

	public function getMenuGroup(){
		return $this->group_;
	}

	public function isMenuGroup($name){
		return ($this->group_===$name);
	}

	public function hasMenu() {
		return (count($this->menu)>0);
	}

}

