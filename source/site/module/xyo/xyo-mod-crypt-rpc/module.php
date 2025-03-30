<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_CryptRPC";

class xyo_mod_CryptRPC extends xyo_Module {

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		
	        if ($this->isOk) {
			if ($this->isBase("xyo_mod_CryptRPC")) {
				include("xyo-crypt.php");
			};
		};
	}

}

