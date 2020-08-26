<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Settings");

$this->set("select.enabled_all", "- enabled -");
$this->set("select.enabled_default_disabled", "- no -");
$this->set("select.enabled_enabled", "yes");
$this->set("select.enabled_disabled", "no");

$this->set("label.website_title","Website title");
$this->set("label.user_logoff_after_idle_time","User logoff after idle time (minutes)");
$this->set("label.user_action","User action");
$this->set("label.user_captcha","User captcha");

$this->set("label.log_module","Log module load failure");
$this->set("label.log_request","Log request");
$this->set("label.log_response","Log response");
$this->set("label.log_language","Log not found language index");

$this->set("title.log","Log");

$this->set("label.login_has_select_language","Login has select language");

$this->set("title.login","Login");