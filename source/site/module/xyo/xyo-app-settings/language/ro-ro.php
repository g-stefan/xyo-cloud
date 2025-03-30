<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Settings");

$this->set("select.enabled_all", "- activat -");
$this->set("select.enabled_default_disabled", "- nu -");
$this->set("select.enabled_enabled", "da");
$this->set("select.enabled_disabled", "nu");

$this->set("label.website_title","Titlu site");
$this->set("label.user_logoff_after_idle_time","Utilizatorul este delogat dupa perioada de inactivitate (minute)");
$this->set("label.user_action","Actiune utilizator");
$this->set("label.user_captcha","Captcha utilizator");

$this->set("label.log_module","Inregistreaza modulele care nu sunt gasite");
$this->set("label.log_request","Inregistreaza cererea");
$this->set("label.log_response","Inregistreaza raspunsul");
$this->set("label.log_language","Inregistreaza index care nu e gasit in limbaj");

$this->set("title.log","Log");

$this->set("label.login_has_select_language","Limba se poate selecta la intrare");

$this->set("title.login","Logare");

$this->set("label.brand_logo","Logo marca");
$this->set("label.brand_name","Nume marca");
$this->set("label.brand_mark","Tip marca");

$this->set("title.security","Securitate");
$this->set("label.csrf_token_refresh","Mitigare CSRF - Actualizeaza la fiecare cerere de tip POST");