<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
defined('XYO_CLOUD_INSTALL') or die('Access is denied');
//
//$this->set("log_module",true);
//$this->set("log_request",true);
//$this->set("log_response",true);
//
$this->set("language", "en-GB");
if ($this->isRequest("website_language")) {
	if (strcmp($this->getRequest("website_language"), "-") != 0) {
		$this->set("language", $this->getRequest("website_language"));
	};
};
/* --- */
$this->includeConfig("config.website");
/* --- */
$this->setModule(null, null, "xyo");
$this->setModule("xyo", null, "xyo-mod-ds-settings");
/* --- */
$this->setModule(null, "install", "xyo-app-install");
$this->setModule("xyo-app-install", null, "xyo-tpl-install");
$this->setModuleGroup("xyo-tpl-install", "system-run");
$this->setModuleAsApplication("xyo-app-install");
$this->setApplication("xyo-app-install");
/* --- */