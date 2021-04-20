<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_xui_Sidebar";

class xyo_mod_xui_Sidebar extends xyo_mod_xui_Menu {

	protected $menu;
	protected $groupSp_;
	protected $group_;

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		$this->process="sidebar";
	}
}

