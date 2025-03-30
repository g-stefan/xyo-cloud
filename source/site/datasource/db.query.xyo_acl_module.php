<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("query_table", array(
	"acl_module" => "db.table.xyo_acl_module",
	"module" => "db.table.xyo_module",
	"module_group" => "db.table.xyo_module_group",
	"user_group" => "db.table.xyo_user_group",
	"core" => "db.table.xyo_core"
));

$this->set("query_item", array(
	"id" => array("acl_module" => "id"),
	"xyo_module_id" => array("acl_module" => "xyo_module_id"),
	"xyo_module_group_id" => array("acl_module" => "xyo_module_group_id"),
	"xyo_user_group_id" => array("acl_module" => "xyo_user_group_id"),
	"xyo_core_id" => array("acl_module" => "xyo_core_id"),
	"enabled" => array("acl_module" => "enabled"),
	"module" => array("acl_module" => "module"),
	"order" => array("acl_module" => "order"),
	"module_name" => array("module" => "name"),
	"module_group_name" => array("module_group" => "name"),
	"user_group_name" => array("user_group" => "name"),
	"core_name" => array("core" => "name")
));

$this->set("query_link", array(
	"acl_module" => "base",
	"module" => array("outer", array("module" => "id"), array("acl_module" => "xyo_module_id")),
	"module_group" => array("outer", array("module_group" => "id"), array("acl_module" => "xyo_module_group_id")),
	"user_group" => array("outer", array("user_group" => "id"), array("acl_module" => "xyo_user_group_id")),
	"core" => array("outer", array("core" => "id"), array("acl_module" => "xyo_core_id"))
));

$this->set("query_save", array(
	"acl_module" => true
));

$this->set("query_delete", array(
	"acl_module" => true
));

$this->set("query_set_order", array(
	"module" => "acl_module",
	"module_group" => "acl_module",
	"user_group" => "acl_module",
	"core" => "acl_module"
));
