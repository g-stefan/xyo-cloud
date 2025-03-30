<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

//
// website settings
//
$this->includeConfig("config.website");
//
if (!$this->get("configured",false)) {
	define("XYO_CLOUD_INSTALL", 1);
	if (file_exists("install/xyo-cloud.install.php")) {
		require_once("install/xyo-cloud.install.php");
	};
	return;
}
$this->set("language", $this->get("default_language", "en-GB"));

//
// modules
//
$this->setModule(null, null, "xyo");
$this->setModule("xyo", null, "xyo-mod-ds-settings");
$this->setModule("xyo", null, "xyo-mod-ds-acl");
$this->setModule("xyo", null, "xyo-mod-ds-user");
$this->setModule("xyo", null, "xyo-mod-ds-module-settings");
$this->setModule("xyo", null, "xyo-mod-ds-user-settings");

//
// process settings
//
$modSettings = &$this->getModule("xyo-mod-ds-settings");
$settings = array(
	"website_title" => "XYO Cloud",
	"user_logoff_after_idle_time" => 15,
	"user_action" => 1,
	"user_captcha" => 1,
	"log_module" => 0,
	"log_request" => 0,
	"log_response" => 0,
	"log_language" => 0,
	"login_has_select_language" => 0, // must be attached to module settings
	"csrf_token_refresh" => 0
);
$modSettings->getSettingsList($settings);
$this->merge($settings);

//
// check for user
//
$modUser = &$this->getModule("xyo-mod-ds-user");
if ($modUser) {
    if ($modUser->isAuthorized()) {
        if ($modUser->info->language) {
            $this->set("language", $modUser->info->language);
        }
    }
}

//
// language from cookie/override user/config
//
$website_language = $this->getRequest("website_language", "*");
if ($website_language !== "*") {
	$this->set("language", $website_language);
}
//
$website_language = $this->getRequest("user_language", "*");
if ($website_language !== "*") {
	$this->set("language", $website_language);
	setcookie("website_language",$website_language,0,$this->siteBase);
}
//
// set module loader ... (must be after user)
//
$this->setModule("xyo", null, "xyo-mod-ds-loader-mod");
$this->setModuleLoader("xyo-mod-ds-loader-mod");
$this->setGroupLoader("xyo-mod-ds-loader-mod");
// other providers
$this->setCSRFMitigationProvider("xyo-mod-ds-user");
//