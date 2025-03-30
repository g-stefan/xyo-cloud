<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_app_UserXUserGroup";

class xyo_app_UserXUserGroup extends xyo_app_Table {

	protected $xyo_user_id;
    
	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		$this->xyo_user_id=0;
	}

}
