<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
