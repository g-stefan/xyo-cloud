<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->tableHead = array(
	"#" => "#",
	"user_group_super" => "head.user_group_super",
	"user_group" => "head.user_group",
	"enabled" => "head.enabled"
);

$this->tableSearch = array(
	"user_group_super" => true,
	"user_group" => true
);

$this->tableSelect = array(
	"user_group" => true,
	"enabled" => true
);

$this->tableType=array(
	"user_group_super" => array("cmd-edit"),
	"enabled" =>array("toggle")
);

$this->tableSort = array(
	"user_group_super" => "ascendent",
	"user_group" => "none",
	"enabled" => "none"
);

$this->processModel("select-xyo-user-group");
$this->processModel("select-enabled");

$this->tableSelectInfo = array(
	"user_group" => $this->getParameter("select.xyo_user_group_id", array()),
	"enabled" => $this->getParameter("select.enabled", array())
);

if ($this->xyo_user_group_id_super) {

	unset($this->tableHead["user_group_super"]);
	unset($this->tableSelect["user_group_super"]);
	unset($this->tableSort["user_group_super"]);
	unset($this->tableSearch["user_group_super"]);
	unset($this->tableType["user_group_super"]);
	unset($this->tableSelect["user_group"]);
	unset($this->tableSelectInfo["user_group"]);    
    
	$this->tableType["user_group"]=array("cmd-edit");
    
} else {

	unset($this->tableSelect["user_group"]);

}

