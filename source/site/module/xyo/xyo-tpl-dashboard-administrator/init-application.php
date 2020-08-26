<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->loadGroup("sidebar");
$this->loadGroup("status");

$this->setHtmlClass("xui");
$this->setHtmlBodyClass("xui");
$this->setHtmlTitle($this->getSetting("website_title","XYO Cloud"));
$this->setHtmlIcon($this->site."lib/xyo/applications-internet.ico");
$this->setHtmlCss($this->site."lib/xyo/xyo-tpl-dashboard.css");
$this->setHtmlJs($this->site."lib/xyo/xyo-tpl-dashboard.js");
