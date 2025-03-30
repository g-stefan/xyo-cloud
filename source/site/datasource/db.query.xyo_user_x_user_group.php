<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("query_table", array(
	"user_x_user_group" => "db.table.xyo_user_x_user_group",
	"user" => "db.table.xyo_user",
	"user_group" => "db.table.xyo_user_group"
));

$this->set("query_item", array(
	"id" => array("user_x_user_group" => "id"),
	"xyo_user_id" => array("user_x_user_group" => "xyo_user_id"),
	"xyo_user_group_id" => array("user_x_user_group" => "xyo_user_group_id"),
	"principal" => array("user_x_user_group" => "principal"),
	"enabled" => array("user_x_user_group" => "enabled"),
	"user_group" => array("user_group" => "name"),
	"name" => array("user" => "name"),
));

$this->set("query_link", array(
	"user_x_user_group" => "base",
	"user_group" => array("outer", array("user_group" => "id"), array("user_x_user_group" => "xyo_user_group_id")),
	"user" => array("outer", array("user" => "id"), array("user_x_user_group" => "xyo_user_id"))
));

$this->set("query_save", array(
	"user_x_user_group" => true
));

$this->set("query_delete", array(
	"user_x_user_group" => true
));

$this->set("query_set_order", array(
	"user_group" => "user_x_user_group",
	"user" => "user_x_user_group"
));
