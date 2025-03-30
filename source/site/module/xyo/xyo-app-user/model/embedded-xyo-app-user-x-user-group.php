<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");


$this->setChildInstance("uxug");
$this->embeddedApplication("xyo-app-user-x-user-group",array(
	"instance"=>$this->childInstance,
	$this->childInstanceV."xyo_user_id" => $this->getArgument("xyo_user_id",0),
	"is_embedded"=>true,
	"is_dialog"=>true,
	"is_inline"=>true
));
