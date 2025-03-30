<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("xyo_cloud_version", "${VERSION_VERSION}");

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
// --- false - default, CSRF request token set at login (not changed after), allow multiple browser tabs
// --- true - force CSRF request token to be changed on every POST request, single tab application
$this->set("csrf_token_refresh",false);
// ---
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
