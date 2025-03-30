<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("table_primary_key", "id");

$this->set("table_item", array(
	"id" => array("bigint","DEFAULT","unsigned","auto_increment"),
	"name" => array("varchar",null,128),
	"description" => array("varchar",null,128),
	"default" => array("int",0,"unsigned"),
	"enabled" => array("int",0,"unsigned")
));

$this->set("table_index", array(	
	"name"
));

$this->set("table_link",array(
	"xyo_user"=>array("db.table.xyo_user","xyo_language_id","id","set",0)
));
