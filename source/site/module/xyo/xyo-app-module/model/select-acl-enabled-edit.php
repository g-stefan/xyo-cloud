<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$enabled = array(
	"1" => $this->getFromLanguage("select.enabled_enabled"),
	"0" => $this->getFromLanguage("select.enabled_disabled")
);

$this->setParameter("select.acl_enabled", $enabled);
