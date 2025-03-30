<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_mod_setup_Link {

	var $setup_;
	var $link_;

	function __construct(&$setup_) {
		$this->setup_ = $setup_;
		$this->link_ = array();
	}

	function loadModuleLink($module) {
		if (array_key_exists($module, $this->link_)) {
			return;
		};
		$this->link_[$module] = array();
		$this->link_[$module]["module"] = $module;
		$this->link_[$module]["version"] = null;
		$path = $this->setup_->getModulePath($module);
		if (!is_null($path)) {
			$file = $path . "cloud.php";
			if (file_exists($file)) {
				include($file);
			};
		};
	}

	function setReferenceLink($derivate, $base) {
		$this->loadModuleLink($base);
	}

	function setReferenceBase($derivate, $base) {
		$this->loadModuleLink($base);
	}

	function getLink() {
		return $this->link_;
	}

	function setVersion($module, $version) {
		if (array_key_exists($module, $this->link_)) {
			$this->link_[$module]["version"] = $version;
		};
	}

	function enableModule($module, $enable) {

	}

	function disableModule($module) {

	}

	function setModuleAsApplication($module,$enabled=true){

	}

	function setModule($moduleParent, $path, $module, $enabled, $registered=false, $override=false) {

	}

	function setModuleCheck($module, $check) {

	}	

	function setModuleGroup($module, $group, $order=0) {

	}

	function removeModule($module) {

	}

	function removeModuleFromGroup($module, $group) {

	}

	function removeGroup($group) {

	}

	function setTemplate($name) {

	}

	function setModuleLoader($name) {

	}

	function setRequestBuilder($name) {

	}

	function setDefaultApplication($name) {

	}

}

