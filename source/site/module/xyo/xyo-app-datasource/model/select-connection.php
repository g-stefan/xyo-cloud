<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$select=array("*"=>$this->getFromLanguage("select.connection_any"));
$selectX=array_keys($this->cloud->dataSource->getDataSourceConnectionProviderList());
foreach($selectX as $value){
	$select[$value]=$value;
};

$this->setParameter("select.connection",$select);
