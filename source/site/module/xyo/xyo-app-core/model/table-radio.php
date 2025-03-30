<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->processModelBase("table-radio");

$this->ds->load(0,1);
if(!$this->ds->default){
	return;
};

$routerContent="";
$routerContent.="<"."?"."php\r\n";
$routerContent.="// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>\r\n";
$routerContent.="// MIT License (MIT) <http://opensource.org/licenses/MIT>\r\n";
$routerContent.="// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>\r\n";
$routerContent.="// SPDX-License-Identifier: MIT\r\n";
$routerContent.="\r\n";
$routerContent.="define(\"XYO_CLOUD_ROUTER_DEFAULT\",1);\r\n";
$routerContent.="define(\"XYO_CLOUD_".strtoupper($this->ds->name)."\",1);\r\n";
$routerContent.="@chdir(\"site\");\r\n";
$routerContent.="require_once(\"xyo/xyo-cloud.php\");\r\n";
$routerContent.="\$xyoCloud=new xyo_Cloud();\r\n";
$routerContent.="defined(\"XYO_CLOUD\") or die(\"Access is denied\");\r\n";
$routerContent.="\$xyoCloud->set(\"request_main\",\"index.php\");\r\n";
$routerContent.="\$xyoCloud->set(\"core\",\"".$this->ds->name."\");\r\n";
$routerContent.="\$xyoCloud->setPathSite(\"site\");\r\n";
$routerContent.="\$xyoCloud->main();\r\n";
	
file_put_contents($this->getCloudPath()."/../index.php",$routerContent);
