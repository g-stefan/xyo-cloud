<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->runModule("xyo-mod-toolbar", array_merge(array(
	"instance" => $this->instance,
	"module" => $this->name,
	"config" => $this->getParameter("toolbar", "toolbar/default"),
	"type" => ($this->isEmbedded)?"small --toolbar":"",
	"embedded" => $this->isEmbedded,
	"dialog" => $this->isDialog,
	"inline" => $this->isInline,
	"process" => "toolbar-left",
	"parent" => $this->name
), $this->toolbarParameter));
