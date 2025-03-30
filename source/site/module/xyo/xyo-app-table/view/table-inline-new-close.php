<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->ejsBegin();
echo "XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."action=table-view\");";
$this->ejsEnd();

// ---

$this->generateView("table-inline-edit");
