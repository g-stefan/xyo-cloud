<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->set("xyo_cloud_version", "$VERSION_VERSION");

//$this->set("log_module",true);
//$this->set("log_request",true);
//$this->set("log_response",true);
//$this->set("log_language",true);
$this->set("use_redirect",true);
$this->set("user_action",true);
$this->set("user_captcha",true);
$this->set("user_password_encoding","hash");
// --- this will be generated automatically by installer in config.website
$this->set("user_login_salt","unknown");
// --- overwrite this in xyo-cloud.local.init
$this->set("user_reco_salt","unknown");
$this->set("service_key","unknown");
$this->set("crypt_rpc_private_key","unknown");
// ---

//
// some default values just in case
//
$this->set("language", "en-GB");
$this->set("locale", "en-GB");
$this->set("locale_date_format","Y-m-d");
$this->set("locale_datetime_format","Y-m-d H:i:s");
$this->set("locale_time_format","H:i:s");
//
//
$this->set("configured", false);
