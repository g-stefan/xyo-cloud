<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setViewTemplate("template");
$this->setDefaultAction($this->getRequestInstance("action", "default"));

$this->requireComponent(array(
	"xui.form-action-begin",
	"xui.form-action-end",
	"xui.box-space"
));
