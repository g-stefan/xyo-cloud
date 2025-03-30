<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$path="package/";
$list=array();
$modSetup=&$this->cloud->getModule("xyo-mod-setup");
if($modSetup){
	$list=$modSetup->getPackageList2($path);
};
if(count($list)){}else{
	$list["*"]=$this->getFromLanguage("package_none");
};

$this->setParameter("select.packages",$list);
