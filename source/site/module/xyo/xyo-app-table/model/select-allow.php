<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$allow = array(
	"*" => $this->getFromLanguage("select.allow_any"),
	"1" => $this->getFromLanguage("select.allow_enabled"),
	"0" => $this->getFromLanguage("select.allow_disabled")
);

$this->setParameter("select.allow", $allow);
