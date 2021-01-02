<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$user_group = &$dataSource;

$user_group->clear();
$user_group->name = "public";
$user_group->tryLoad();
$user_group->enabled = 1;
$user_group->save();

$user_group->clear();
$user_group->name = "authenticated";
$user_group->tryLoad();
$user_group->enabled = 1;
$user_group->save();

$user_group->clear();
$user_group->name = "administrator";
$user_group->tryLoad();
$user_group->enabled = 1;
$user_group->save();

$user_group->clear();
$user_group->name = "wheel";
$user_group->tryLoad();
$user_group->enabled = 1;
$user_group->save();
