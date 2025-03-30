<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

//
// Shorcut to xyoCloud configured instance
//

if (defined("XYO_CLOUD")) {
	return;
};
define("XYO_CLOUD_INSTANCE", 1);

$xyoCloudServiceConfigOnly=true;

require_once("xyo-cloud-service.php");

$backtrace = debug_backtrace();
if (!empty($backtrace[0]) && is_array($backtrace[0])) {
	$xyoCloud->includeFile($backtrace[0]["file"]);
};	

die;