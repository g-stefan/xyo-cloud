<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->tableHead = array(
	"#" => "#",
	"name" => "head.name",
	"username" => "head.username",
	"logged_in" => "head.logged_in",
	"logged_at" => "head.logged_at",
	"created_at" => "head.created_at",
	"invisible" => "head.invisible",
	"enabled" => "head.enabled"
);

$this->tableSearch = array(
	"name" => true,
	"username" => true
);

$this->tableSelect = array(
	"xyo_user_group_id" => true,
	"enabled" => true
);

$this->tableType=array(
	"name" => array("cmd-edit"),
	"enabled"=>array("toggle"),	
	"invisible"=>array("toggle",array(
		"on"=>array(
			0=>array("<i class=\"material-icons\">add</i>","default"),
			1=>array("<i class=\"material-icons\">flag</i>","warning")
		)
	)),	
	"logged_in"=>array("toggle"),
	"logged_at"=>array("datetime"),
	"created_at"=>array("datetime")
);

$this->tableSort = array(
	"name" => "ascendent",
	"username" => "none",
	"logged_in" => "none",
	"logged_at" => "none",
	"created_at" => "none",
	"invisible" => "none",
	"enabled" => "none"
);

$this->processModel("select-xyo-user-group");
$this->processModel("select-enabled");

$this->tableSelectInfo = array(
	"xyo_user_group_id" => $this->getParameter("select.xyo_user_group_id", array()),
	"enabled" => $this->getParameter("select.enabled", array())
);

$this->tableDelete = array(
	"name" => true,
	"username" => true
);

$this->tableImportant=array(
	"name"=>true
);

if($this->isInlineForm){
	$this->tableHead = array(
		"#" => "#",
		"name" => "head.name"
	);

	$this->tableType=array(	  
		"name"=>array("custom","table-view-cell-name"),
	);
	
	$this->tableData=array(
		"picture" => "picture",
		"logged_in" => "logged_in",
		"logged_at" => "logged_at",
		"created_at" => "created_at",
		"invisible" => "invisible",
		"description" => "description",
		"enabled" => "enabled"
	);
};


