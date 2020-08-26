<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setItemBefore("delete","package_uninstall",
        "item-js",
        "<i class=\"material-icons\">remove_circle</i>",
        "package_uninstall",
        "danger",
        "#",
        $this->instanceV."doCommand('package-uninstall');"
);

$this->setItemBefore("package_uninstall","package_link",
        "item-js",
        "<i class=\"material-icons\">storage</i>",
        "package_link",
        "primary",
        "#",
        $this->instanceV."doCommand('create-package-link');"
);

$this->setItemBefore("package_link","package_new",
        "item-js",
        "<i class=\"material-icons\">storage</i>",
        "package_new",
        "primary",
        "#",
        $this->instanceV."doCommand('create-package');"
);

$this->setItemBefore("package_new","module_parameter",
        "item-js",
        "<i class=\"material-icons\">list</i>",
        "module_parameter",
       	"primary",
        "#",
        "callModuleParameter();"
);

$this->setItemAfter("module_parameter","module_acl",
        "item-js",
        "<i class=\"material-icons\">lock</i>",
        "module_acl",
        "primary",
        "#",
        "callModuleAcl();"
);

