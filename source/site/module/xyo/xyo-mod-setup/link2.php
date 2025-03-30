<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_mod_setup_Link2 {

	var $setup_;
	var $link_;

	function __construct(&$setup_) {
		$this->setup_ = $setup_;
		$this->link_ = array();
	}

	function getModuleLinkFromString($module, $string_) {
		$this->link_ = array();
		eval("?>" . $string_);
		return $this->link_;
	}

	function setReferenceLink($derivate, $base) {
		$this->link_[$base] = $base;
	}

	function setReferenceBase($derivate, $base) {
		$this->link_[$base] = $base;
	}

	function setVersion($module, $version) {

	}

	function enableModule($module, $enable) {

	}

	function disableModule($module, $enable) {

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

