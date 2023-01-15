<?php
// Copyright (c) 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->toolbarPush();

$this->setItem("logout",
        "item-js",
        "<i class=\"material-icons\">lock</i>",
        "logout",
        "warning",
        "#",
        $this->instanceV."doCommand('logout');"
);

$this->setItem("user_group",
        "item-js",
        "<i class=\"material-icons\">people</i>",
        "user_group",
       	"primary",
        "#",
        "callUserXUserGroup();"
);

$this->setItem("separator-table","separator",null,null,null,null,null);

$this->toolbarPop();
