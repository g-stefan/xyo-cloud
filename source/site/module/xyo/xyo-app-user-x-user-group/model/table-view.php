<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->tableHead = array(
	"#" => "#",
	"name" => "head.name",
	"user_group" => "head.user_group",
	"principal" => "head.principal",
	"enabled" => "head.enabled"
);

$this->tableSearch = array(
	"name" => true,
	"user_group" => true
);

$this->tableSelect = array(
	"xyo_user_group_id" => true,
	"enabled" => true
);

$this->tableType=array(
	"name" => array("cmd-edit"),
	"principal"=>array("toggle",array(
		"on"=>array(
			0=>array("<i class=\"material-icons\">star_border</i>",""),
			1=>array("<i class=\"material-icons\">star</i>","warning")
		)
	)),
	"enabled"=>array("toggle")		
);

$this->tableSort = array(
	"name" => "ascendent",
	"user_group" => "none",
	"enabled" => "none"
);

if (!$this->xyo_user_id) {
	$this->processModel("select-xyo-user-group");
};

$this->processModel("select-enabled");
$this->processModel("select-allow");

$this->tableSelectInfo = array(
	"xyo_user_group_id" => $this->getParameter("select.xyo_user_group_id", array()),
	"enabled" => $this->getParameter("select.enabled", array())
);

if ($this->xyo_user_id) {
	unset($this->tableHead["name"]);
	unset($this->tableSelect["name"]);
	unset($this->tableSort["name"]);
	unset($this->tableSearch["name"]);
	unset($this->tableType["name"]);
	unset($this->tableSelect["xyo_user_group_id"]);
	unset($this->tableSelectInfo["xyo_user_group_id"]);
    
	$this->tableType["user_group"] =array("cmd-edit");
    
} else {
	unset($this->tableSelect["xyo_user_group_id"]);
	unset($this->tableSort["user_group"]);
};
