<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_PearArchiveTar";

class lib_PearArchiveTar extends xyo_Module {

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_PearArchiveTar")) {
			require_once($this->path . "pear-archive-tar.php");
		}
	}

}
