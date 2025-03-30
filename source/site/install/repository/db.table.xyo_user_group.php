<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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
