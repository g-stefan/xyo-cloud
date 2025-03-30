<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->loadGroup("sidebar");
$this->loadGroup("status");

$this->setHtmlClass("h-full");
$this->setHtmlBodyClass("h-full");
$this->setHtmlTitle($this->cloud->get("website_title","XYO Cloud"));
$this->setHtmlIcon($this->site."lib/xyo/applications-internet.ico");
