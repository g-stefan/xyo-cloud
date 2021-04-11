<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->toolbarPush();

$this->setItem("user_group",
        "item-js",
        "<i class=\"material-icons\">people</i>",
        "user_group",
        "primary",
        "#",
        "callUserGroupXUserGroup();"
);

$this->setItem("separator-table","separator",null,null,null,null,null);

$this->toolbarPop();
