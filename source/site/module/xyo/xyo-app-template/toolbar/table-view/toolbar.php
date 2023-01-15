<?php
// Copyright (c) 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->removeItem("delete");
$this->removeItem("edit");
$this->removeItem("new");

$this->toolbarPush();

$this->setItem("module_settings",
        "item-js",
        "<i class=\"material-icons\">list</i>",
        "module_settings",
        "primary",
        "#",
        "callModuleSettings();"
);

$this->setItem("module_acl",
        "item-js",
        "<i class=\"material-icons\">lock</i>",
        "module_acl",
        "primary",
        "#",
        "callModuleAcl();"
);

$this->toolbarPop();
