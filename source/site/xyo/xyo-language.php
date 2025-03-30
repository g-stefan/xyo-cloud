<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_Language extends xyo_Attributes {

	protected $cloud;
	protected $log;
	public $type;
	public $name;
	public $moduleName;

	public function __construct(&$cloud, $moduleName) {
		parent::__construct();
		$this->cloud = &$cloud;
		$this->log = $this->cloud->get("log_language");
		$this->type = "ltr";
		$this->name = "en";
		$this->moduleName = $moduleName;
	}

	public function get($name, $default=null) {
		if ($name) {
			if (array_key_exists($name, $this->attributes_)) {
				return $this->attributes_[$name];
			};
		};
		if ($default) {
			return $default;
		};
		if ($this->log) {
			$this->cloud->logMessage("language", "[" . $this->moduleName . "] NOT-FOUND:" .$this->name . ":" . $name);
		};
		return $name;
	}

	public function setLanguage($name) {
		$this->name = $name;
	}

	public function isLanguage($name) {
		if ($this->name === $name) {
			return true;
		}
		return false;
	}

	public function setLanguageType($type) {
		$this->type = $type;
	}

	public function getLanguageType() {
		return $this->type;
	}

	public function isLanguageType($type) {
		if ($this->type === $type) {
			return true;
		}
		return false;
	}

}

