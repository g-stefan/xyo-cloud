<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if(!$this->xyo_user_id){
	$this->processModel("select-xyo-user");
};

$this->processModel("select-xyo-user-group-edit");
$this->processModel("select-enabled-edit");
$this->copyParameter("select.principal","select.enabled");
