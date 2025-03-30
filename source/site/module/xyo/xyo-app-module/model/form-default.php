<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setElementValue("id",0);
$this->setElementValue("path","");
$this->setElementValue("name","");
$this->setElementValue("description","");
$this->setElementValue("enabled",1);
$this->setElementValue("parent","");

if($this->isNew){
	$this->setElementValue("xyo_module_group_id",0);
	$this->setElementValue("order",0);
	$this->setElementValue("xyo_core_id",0);
	$this->setElementValue("xyo_user_group_id",0);
	$this->setElementValue("acl_enabled",1);
};
