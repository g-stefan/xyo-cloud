<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$language = &$dataSource;

$language->clear();
$language->name = "administrator";
$language->tryLoad();
$language->path = "admin";
$language->default = 1;
$language->description = "";
$language->enabled = 1;
$language->save();

$language->clear();
$language->name = "public";
$language->tryLoad();
$language->path = "";
$language->default = 0;
$language->description = "";
$language->enabled = 1;
$language->save();

