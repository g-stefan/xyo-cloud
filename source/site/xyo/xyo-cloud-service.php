<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

//
// Run a module from current directory, to be used as service
//
// - string $xyoCloudServiceModuleName (optional) Module name to be "seen"
//      by the system, default to "-service-"
// Example:
//      in service.php
//      $xyoCloud...  - options
//      include([path to "xyo-cloud-service.php" ]);
//
// Another example:
//      in application.php - main module script
//
//      $xyoCloud...  - options
//	include([path to "xyo-cloud-service.php" ]);
//	defined("XYO_CLOUD") or die("Access is denied");
//
//      ... module code ...
//

//
// Options
//
//	$xyoCloudServiceConfigOnly
//	$xyoCloudServiceRequestMain
//	$xyoCloudServiceSite
//	$xyoCloudServiceModuleName
//

if (defined("XYO_CLOUD")) {
	return;
};
define("XYO_CLOUD_SERVICE", 1);

require_once("xyo-cloud.php");
$xyoCloud = new xyo_Cloud();
defined("XYO_CLOUD") or die("Access is denied");

if(isset($xyoCloudServiceSite)) {
	$xyoCloud->set("site",$xyoCloudServiceSite);
};
if(isset($xyoCloudServiceRequestMain)) {
	$xyoCloud->set("request_main",$xyoCloudServiceRequestMain);
};

if (!isset($xyoCloudServiceModuleName)) {
	$xyoCloudServiceModuleName = "-service-";
};

$run=$xyoCloud->getRequest("run", $xyoCloudServiceModuleName);
if($run==$xyoCloudServiceModuleName) {
	$xyoCloud->setModule(null, getcwd(), $xyoCloudServiceModuleName, true, false, true);
	$xyoCloud->setModuleCheck($xyoCloudServiceModuleName, false);
	$xyoCloud->setRequest("run", $xyoCloudServiceModuleName);
};
if(!isset($xyoCloudServiceConfigOnly)) {
	$xyoCloud->main();	
	exit();
}else{
	$xyoCloud->initRequest();
	$xyoCloud->dataSource->loadConfig();	
};

