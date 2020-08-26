<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
//
// process settings
//
$dsSettings=&$this->dataSource->getDataSource("db.table.xyo_settings");
$dsSettings->clear();
for($dsSettings->load();$dsSettings->isValid();$dsSettings->loadNext()){
	$this->set($dsSettings->name,$dsSettings->value);		
};

//
//
$this->setModule(null, null, "xyo");
$this->setModule("xyo", null, "xyo-mod-ds-acl");
$this->setModule("xyo", null, "xyo-mod-ds-user");
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
//
//