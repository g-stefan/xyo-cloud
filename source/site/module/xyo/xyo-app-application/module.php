<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_app_Application";

class xyo_app_Application extends xyo_mod_Application {

	//
	protected $toolbarParameter;
	//
	protected $useNotify;

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);

		$this->toolbarParameter = array();
		$this->useNotify = true;
	}

	public function setUseNotify($value) {
		$this->useNotify = false;
	}

	public function getPrimaryKeyValueOneElementOrRequest() {
		return 1*$this->getPrimaryKeyValueOne($this->getElementValueString("primary_key_value", $this->getRequestInstance("primary_key_value")));
	}

	public function getPrimaryKeyValueOneRequest() {
		return 1*$this->getPrimaryKeyValueOne($this->getRequestInstance("primary_key_value"));
	}

}
