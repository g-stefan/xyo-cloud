<?php
// 
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//
define("XYO_CLOUD_ADMINISTRATOR",1);
@chdir("../site");
require_once("xyo/xyo-cloud.php");
$xyoCloud=new xyo_Cloud();
defined("XYO_CLOUD") or die("Access is denied");
$xyoCloud->set("request_main","index.php");
$xyoCloud->set("core","administrator");
$xyoCloud->setPathSite("../site");
$xyoCloud->main();
