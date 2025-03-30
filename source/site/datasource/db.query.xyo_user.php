<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("query_table", array(
	"user" => "db.table.xyo_user",
	"user_x_user_group" => "db.table.xyo_user_x_user_group",
	"user_group" => "db.table.xyo_user_group",
	"language" => "db.table.xyo_language"
));

$this->set("query_item", array(
	"id" => array("user"=>"id"),
	"xyo_user_id" => array("user"=>"xyo_user_id"),
	"username" => array("user"=>"username"),
	"password" => array("user"=>"password"),
	"session" => array("user"=>"session"),
	"invisible" => array("user"=>"invisible"),
	"enabled" => array("user"=>"enabled"),
	"picture" => array("user"=>"picture"),
	"description" => array("user"=>"description"),
	"email" => array("user"=>"email"),
	"name" => array("user"=>"name"),
	"created_at" => array("user"=>"created_at"),
	"logged_at" => array("user"=>"logged_at"),
	"logged_in" => array("user"=>"logged_in"),
	"action_at" => array("user"=>"action_at"),
	"user_group" => array("user_group"=>"name"),
	"language" => array("language"=>"name"),
	"xyo_user_group_id" => array("user_group"=>"id"),
	"xyo_language_id" => array("user"=>"xyo_language_id")
));


$this->set("query_link", array(
	"user" => "base",
	"user_x_user_group" => array("outer",array("user_x_user_group"=>"xyo_user_id"),array("user"=>"id")),
	"user_group" => array("outer",array("user_group"=>"id"),array("user_x_user_group"=>"xyo_user_group_id")),
	"language" => array("outer",array("language"=>"id"),array("user"=>"xyo_language_id"))
));


$this->set("query_save", array(
	"user" => true
));

$this->set("query_delete", array(
	"user" => true
));

$this->set("query_set_order", array(
	"language" => "user",
	"user_x_user_group" => "user_group", 
	"user" => "user_x_user_group"
));

