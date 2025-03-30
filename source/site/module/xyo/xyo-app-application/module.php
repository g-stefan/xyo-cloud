<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_app_Application";

class xyo_app_Application extends xyo_mod_Application {

	//
	protected $toolbarParameter;
	protected $toolbarLeftParameter;
	protected $hasLeftToolbar;
	protected $hasApplicationMenu;
	//
	protected $useNotify;

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);

		$this->toolbarParameter = array();
		$this->useNotify = true;

		$this->toolbarLeftParameter = array();
		$this->hasLeftToolbar = false;
		$this->hasApplicationMenu = false;
	}

	public function setUseNotify($value) {
		$this->useNotify = false;
	}

	public function getPrimaryKeyValueOneElementOrRequest() {
		return $this->getPrimaryKeyValueOne($this->getElementValueString("primary_key_value", $this->getRequestInstance("primary_key_value")));
	}

	public function getPrimaryKeyValueOneRequest() {
		return $this->getPrimaryKeyValueOne($this->getRequestInstance("primary_key_value"));
	}

}
