<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->toolbarPush();

$this->setItem("module_acl",
        "item-js",
        "<i class=\"lucide-lock\"></i>",
        "module_acl",
        "primary",
        "#",
        "callModuleAcl();"
);

$this->setItem("separator-table","separator",null,null,null,null,null);

$this->toolbarPop();
