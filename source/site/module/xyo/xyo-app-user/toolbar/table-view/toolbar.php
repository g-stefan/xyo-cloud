<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setItemBefore("delete","logout",
        "item-js",
        "<i class=\"material-icons\">lock</i>",
        "logout",
        "warning",
        "#",
        $this->instanceV."doCommand('logout');"
);

$this->setItemAfter("logout","user_group",
        "item-js",
        "<i class=\"material-icons\">people</i>",
        "user_group",
       	"primary",
        "#",
        "callUserXUserGroup();"
);

$this->setItem("new",
        "item-js",
        "<i class=\"material-icons\">add</i>",
        "new",
        "primary",
        "#",
        $this->instanceV."doCommand('form-new');"
);
