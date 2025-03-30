<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$invisible = array(
	"*" => $this->getFromLanguage("select.invisible_any"),
	"1" => $this->getFromLanguage("select.invisible_enabled"),
	"0" => $this->getFromLanguage("select.invisible_disabled")
);

$this->setParameter("select.invisible", $invisible);
