<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title","Datasource backup");
$this->set("msg_done","Done");
$this->set("msg_total","Total");
$this->set("form.title_select","Select");
$this->set("backup_title","Backup");

$this->set("unknown_layer", "Unknown database layer:");
$this->set("config_not_writable", "Unable to write config file:");
$this->set("connection_error", "Unable to connect:");
$this->set("connection_unknown", "Unknown connection:");
$this->set("config_file_invalid", "Invalid configuration file");
$this->set("error.datasource_init", "Datasource initialization error");
$this->set("datasource_not_found", "Datasource not found:");

$this->set("select.connection", "Connection:");
$this->set("backup_to","Backup to:");

//---

$this->set("label.server","Server");
$this->set("label.port","Port");
$this->set("label.username","Username");
$this->set("label.password","Pasword");
$this->set("label.database","Database");
$this->set("label.prefix","Prefix");
$this->set("label.retype_password","Retype pasword");
$this->set("label.website_title","Website title");

//---

