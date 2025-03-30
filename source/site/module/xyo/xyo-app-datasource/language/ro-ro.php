<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Sursa de date");

$this->set("head.name", "Nume");
$this->set("head.connection", "Conexiune");
$this->set("head.id", "Id");

$this->set("label.name", "Nume");
$this->set("label.connection", "Conexiune");
$this->set("select.connection_any", "- conexiune -");

$this->set("label.option", "Optiune");
$this->set("select.option_none", "- nimic -");
$this->set("select.option_create", "creeaza");
$this->set("select.option_recreate", "recreeaza");
$this->set("select.option_destroy", "distruge");

$this->set("datasource_create","Stocarea sursei de date a fost creata");
$this->set("datasource_recreate","Stocarea sursei de date a fost recreata");
$this->set("datasource_destroy","Stocarea sursei de date a fost distrusa");
