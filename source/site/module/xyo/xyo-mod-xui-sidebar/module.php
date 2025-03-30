<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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

