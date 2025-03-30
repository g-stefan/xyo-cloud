<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_datasource_quantum_Connection {

	var $module;
	var $name;

	function __construct(&$module, $name) {
		$this->module = &$module;
		$this->name = $name;
	}

	function open() {
		return true;
	}

	function close() {

	}

}


