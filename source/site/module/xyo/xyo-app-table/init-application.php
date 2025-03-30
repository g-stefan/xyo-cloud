<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setDefaultAction($this->getRequestInstance("action", "table-view"));

$this->requireComponent("xui.modal");
$this->requireComponent("xui.inline");
$this->requireComponent("xui.form-select");
$this->requireComponent("xui.form-select-multiple");

if(!$this->isInline) {
	if($this->isAjax()&&($this->embeddedDialogStep==0)){
		$this->setViewTemplate(null);
	};
};
