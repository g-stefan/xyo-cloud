<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->toolbarPush();

$this->setItem("module_acl",
        "item-js",
        "<i class=\"material-icons\">lock</i>",
        "module_acl",
        "primary",
        "#",
        "callModuleAcl();"
);

$this->setItem("module_settings",
        "item-js",
        "<i class=\"material-icons\">list</i>",
        "module_settings",
       	"primary",
        "#",
        "callModuleSettings();"
);

$this->setItem("package_new",
        "item-js",
        "<i class=\"material-icons\">storage</i>",
        "package_new",
        "primary",
        "#",
        $this->instanceV."doCommand('create-package');"
);

$this->setItem("package_link",
        "item-js",
        "<i class=\"material-icons\">storage</i>",
        "package_link",
        "primary",
        "#",
        $this->instanceV."doCommand('create-package-link');"
);

$this->setItem("package_uninstall",
        "item-js",
        "<i class=\"material-icons\">remove_circle</i>",
        "package_uninstall",
        "danger",
        "#",
        $this->instanceV."doCommand('package-uninstall');"
);

$this->setItem("separator-table","separator",null,null,null,null,null);

$this->toolbarPop();
