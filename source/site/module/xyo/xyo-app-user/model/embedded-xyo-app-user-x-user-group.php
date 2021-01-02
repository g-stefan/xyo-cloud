<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");


$this->setChildInstance("uxug");
$this->embeddedApplication("xyo-app-user-x-user-group",array(
	"instance"=>$this->childInstance,
	$this->childInstanceV."xyo_user_id" => $this->getArgument("xyo_user_id",0),
	"is_embedded"=>true,
	"is_dialog"=>true,
	"is_inline"=>true
));
