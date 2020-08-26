<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->clearToolbar();

$this->setItem("module_parameter",
        "item-js",
        "<i class=\"material-icons\">list</i>",
        "module_parameter",
        "primary",
        "#",
        "callModuleParameter();"
);

$this->setItem("module_acl",
        "item-js",
        "<i class=\"material-icons\">lock</i>",
        "module_acl",
        "primary",
        "#",
        "callModuleAcl();"
);
