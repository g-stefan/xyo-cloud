<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("table_primary_key", "id");

$this->set("table_item", array(
	"id" => array("bigint","DEFAULT","unsigned","auto_increment"),
	"xyo_user_id" => array("bigint",0,"unsigned"), // user creator - 0 - creator is one of the system users
	"username" => array("varchar",null,255),
	"password" => array("varchar",null,255),
	"session" => array("varchar",null,255),
	"enabled" => array("int",0,"unsigned"),
	"name" => array("varchar",null,255),
	"created_at" => array("datetime",null),
	"logged_at" => array("datetime",null),
	"logged_in" => array("int",0,"unsigned"),
	"action" => array("int",0,"unsigned"), // authorization checks
	"action_at" => array("datetime",null), // last time when an authorization was requested
	"xyo_language_id" => array("bigint",0,"unsigned"),
	"picture" => array("varchar",null,255),
	"description" => array("varchar",null,255),
	"email" => array("varchar",null,255),
	"invisible" => array("int",0,"unsigned")
));

$this->set("table_index", array(
	"xyo_user_id",
	"username",
	"name"
));

$this->set("table_link",array(
	"xyo_user_x_user_group"=>array("db.table.xyo_user_x_user_group","xyo_user_id","id","delete"),
	"xyo_user"=>array("db.table.xyo_user","xyo_user_id","id","set",0),
	"xyo_user_settings"=>array("db.table.xyo_user_settings","xyo_user_id","id","delete"),
	"xyo_user_x_moule_settings"=>array("db.table.xyo_user_settings","xyo_user_id","id","delete")
));
