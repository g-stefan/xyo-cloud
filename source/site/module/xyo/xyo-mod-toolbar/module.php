<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_Toolbar";

class xyo_mod_Toolbar extends xyo_mod_Application {

	protected $toolbar;
	protected $config;
	protected $type;
	protected $isEmbedded;
	protected $isDialog;
	protected $isInline;
	protected $toolbarPush_;
	protected $process;
	protected $parent;

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
	}

	public function moduleMain() {
		$this->setInstance($this->getParameter("instance", ""));
		$this->toolbar = array();
		$this->config = $this->getParameter("config", "toolbar");
		$this->type = $this->getParameter("type", "");
		$this->isEmbedded = $this->getParameter("embedded", false);
		$this->isDialog = $this->getParameter("dialog", false);
		$this->isInline = $this->getParameter("inline", false);
		$this->toolbarPush_ = array();
		$this->process = $this->getParameter("process", "toolbar");
		$this->parent = $this->getParameter("parent", null);

		if(strlen($this->type)){
			$this->type="--".$this->type;
		};

		$group = $this->getParameter("group");
		if ($group) {
			$this->addGroup($group);
		};
		$module = $this->getParameter("module");
		if ($module) {
			$this->addModule($module);
		};
		$this->generateView();
	}

	public function addGroup($name) {
		$list = &$this->cloud->getGroup($name);
		if (count($list)) {
			foreach ($list as $value) {
				$this->addModule($value);
			};
		};
	}

	public function addModule($module) {
		$mod=&$this->getModule($module);
		if($mod){
			$modPathBase=$mod->getPathBase();

			foreach(array_reverse($modPathBase,true) as $path) {
				$this->loadLanguageFromPathDirect($path . $this->config ."/language/",$this->getSystemLanguage());
			};

			foreach(array_reverse($modPathBase,true) as $path) {
				$file = $path . $this->config . "/".$this->process.".php";
				if (file_exists($file)) {
					include($file);
				};
			};
		};
	}

	public function setItem($id, $type, $img, $title, $mode, $module, $parameters=null) {
		$item = array();
		$item["type"] = $type;
		$item["img"] = $img;
		if($title){		
			$item["title"] = $this->getFromLanguage($title);
		} else {
			$item["title"] = "&#160;";
		};
		$item["mode"] = $mode;
		$item["module"] = $module;
		$item["parameters"] = $parameters;
		$this->toolbar[$id] = &$item;
	}

	public function setItemBefore($idX, $id, $type, $img, $title, $mode, $module, $parameters=null) {
		$item = array();
		$item["type"] = $type;
		$item["img"] = $img;
		if($title){
			$item["title"] = $this->getFromLanguage($title);
		} else {
			$item["title"] = "&#160;";
		};
		$item["mode"] = $mode;
		$item["module"] = $module;
		$item["parameters"] = $parameters;
		if(array_key_exists($idX,$this->toolbar)){
			$tmp=array();
			foreach($this->toolbar as $key=>$value){
				if($key===$idX){
					$tmp[$id]=&$item;
				};
				$tmp[$key]=$value;
			};
			$this->toolbar=$tmp;
		} else {
			$this->toolbar[$id] = &$item;
		};
	}

	public function setItemAfter($idX, $id, $type, $img, $title, $mode, $module, $parameters=null) {
		$item = array();
		$item["type"] = $type;
		$item["img"] = $img;
		if($title){
			$item["title"] = $this->getFromLanguage($title);
		} else {
			$item["title"] = "&#160;";
		};
		$item["mode"] = $mode;
		$item["module"] = $module;
		$item["parameters"] = $parameters;
		if(array_key_exists($idX,$this->toolbar)){
			$tmp=array();
			foreach($this->toolbar as $key=>$value){
				$tmp[$key]=$value;
				if($key===$idX){
					$tmp[$id]=&$item;
				};
			};
			$this->toolbar=$tmp;
		} else {
			$this->toolbar[$id] = &$item;
		};
	}

	public function removeItem($id) {
		if(array_key_exists($id,$this->toolbar)){
			unset($this->toolbar[$id]);
		};
	}

	public function clearToolbar() {
		$this->toolbar=array();
	}

	public function toolbarPush() {
		$this->toolbarPush_ = $this->toolbar;
		$this->toolbar = array();
	}

	public function toolbarPop() {
		$this->toolbar = array_merge($this->toolbar,$this->toolbarPush_);
		$this->toolbarPush_ = array();
	}

	private function cssClassNoPurge(){
		return [
			"xui-button --default",
			"xui-button --primary",	
			"xui-button --secondary",
			"xui-button --success",
			"xui-button --danger",
			"xui-button ---warning",
			"xui-button --info",
			"xui-button --disabled"
		];
	}
}
