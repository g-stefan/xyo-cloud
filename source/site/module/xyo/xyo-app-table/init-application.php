<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setDefaultAction($this->getRequestInstance("action", "table-view"));

$this->requireComponent("xui.modal");
$this->requireComponent("xui.inline");
$this->requireComponent("xui.form-select");
$this->requireComponent("xui.form-select-multiple");

if(!$this->isInline) {
	if($this->isAjax()){
		$this->setViewTemplate(null);
	};
};
