<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT
define("XYO_CLOUD_ROUTER_DEFAULT",1);
define("XYO_CLOUD_ADMINISTRATOR",1);
@chdir("site");
require_once("xyo/xyo-cloud.php");
$xyoCloud=new xyo_Cloud();
defined("XYO_CLOUD") or die("Access is denied");
$xyoCloud->set("request_main","index.php");
$xyoCloud->set("core","administrator");
$xyoCloud->setPathSite("site");
$xyoCloud->main();
