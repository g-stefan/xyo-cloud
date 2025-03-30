<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Datasource");

$this->set("head.name", "Name");
$this->set("head.connection", "Connection");
$this->set("head.id", "Id");

$this->set("label.name", "Name");
$this->set("label.connection", "Connection");
$this->set("select.connection_any", "- connection -");

$this->set("label.option", "Option");
$this->set("select.option_none", "- none -");
$this->set("select.option_create", "create");
$this->set("select.option_recreate", "recreate");
$this->set("select.option_destroy", "destroy");

$this->set("datasource_create","Datasource storage created");
$this->set("datasource_recreate","Datasource storage recreated");
$this->set("datasource_destroy","Datasource storage destroyed");
