<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setElementValue("id",$this->ds->id);
$this->setElementValue("name",$this->ds->name);
$this->setElementValue("description",$this->ds->description);
$this->setElementValue("default",$this->ds->default);
$this->setElementValue("enabled",$this->ds->enabled);
