<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$allow = array(
	"1" => $this->getFromLanguage("select.allow_enabled"),
	"0" => $this->getFromLanguage("select.allow_disabled")
);

$this->setParameter("select.allow", $allow);
