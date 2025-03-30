<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_datasource_xyo_Connection {

	var $module;
	var $name;
	var $databasePath;
	
	function __construct(&$module, $name, $databasePath) {
		$this->module = &$module;
		$this->name = $name;
		$this->databasePath = $databasePath;
	}

	function open() {
		if ($this->databasePath) {
			return true;
		}
		return false;
	}

	function close() {

	}

	function destroyStorage($storage) {
		$fileName = $this->databasePath . $storage . ".php";
		if (file_exists($fileName)) {
			return unlink($fileName);
		};
		return true;
	}

	function renameStorage($oldName,$newName) {
		$fileNameOld = $this->databasePath . $oldName . ".php";
		$fileNameNew = $this->databasePath . $newName . ".php";
		if (file_exists($fileNameOld)) {
			return rename ($fileNameOld, $fileNameNew);
		};
		return false;
	}
};
