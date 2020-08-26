<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setElementValue("id",$this->ds->id);
$this->setElementValue("xyo_user_group_id_super",$this->ds->xyo_user_group_id_super);
$this->setElementValue("xyo_user_group_id",$this->ds->xyo_user_group_id);
$this->setElementValue("enabled",$this->ds->enabled);
