<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$language = &$dataSource;

$language->clear();
$language->name = "en-GB";
$language->tryLoad();
$language->description = "English (United Kingdom)";
$language->enabled = 1;
$language->save();

$language->clear();
$language->name = "ro-RO";
$language->tryLoad();
$language->description = "Romana (Romania)";
$language->enabled = 1;
$language->save();

