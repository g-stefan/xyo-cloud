<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setItem("apply", "item-js.important", "<i class=\"lucide-check\"></i>", "apply", "warning", "#", $this->instanceV."doCommand('form-new-apply')");
$this->setItem("save", "item-js.important", "<i class=\"lucide-check-check\"></i>", "save", "success", "#", $this->instanceV."doCommand('table-new-save')");

$this->setItem("separator-cancel","separator",null,null,null,null,null);

$this->setItem("cancel", "item-js.important", "<i class=\"lucide-x\"></i>", "cancel", "danger", "#", $this->instanceV."doCommand('table-view')");
