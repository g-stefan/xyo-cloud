<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ds->setGroup("id",true);
$this->ds->setGroup("xyo_user_group_id",true);
$this->ds->setGroup("language",true);

if(!$this->user->isInGroup("wheel")){
	$this->ds->pushOperator("and");
	$this->ds->setOperator("user_group","!=","wheel",null,false,false);	
};
