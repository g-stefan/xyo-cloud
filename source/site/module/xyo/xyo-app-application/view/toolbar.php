<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->runModule("xyo-mod-toolbar", array_merge(array(
	"instance" => $this->instance,
	"module" => $this->name,
	"config" => $this->getParameter("toolbar", "toolbar/default"),
	"type" => ($this->isEmbedded)?"small -toolbar":"",
	"embedded" => $this->isEmbedded,
	"dialog" => $this->isDialog,
	"inline" => $this->isInline,
	"parent" => $this->name
), $this->toolbarParameter));
