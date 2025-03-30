<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setElementValue("id",$this->ds->id);
$this->setElementValue("name",$this->ds->name);
$this->setElementValue("username",$this->ds->username);
$this->setElementValue("password1","");
$this->setElementValue("password2","");
$this->setElementValue("xyo_language_id",$this->ds->xyo_language_id);
$this->setElementValue("picture",$this->ds->picture);
$this->setElementValue("description",$this->ds->description);
$this->setElementValue("email",$this->ds->email);
