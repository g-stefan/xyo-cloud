<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

//
// Shorcut to xyoCloud module configured instance with autorun
//

if (defined("XYO_CLOUD")) {
	return;
};

define("XYO_CLOUD_INSTANCE", 1);
define("XYO_CLOUD_RUN", 1);

$xyoCloudServiceConfigOnly=true;

require_once("xyo-cloud-service.php");

$run=$xyoCloud->getRequest("run", $xyoCloudServiceModuleName);
if($run==$xyoCloudServiceModuleName) {
	$moduleInstance=&$xyoCloud->getModule($run);
	$moduleRun = null;
	$backtrace = debug_backtrace();
	if (!empty($backtrace[0]) && is_array($backtrace[0])) {
		$moduleInstance->includeFile($backtrace[0]["file"]);
	};	
};

die;
