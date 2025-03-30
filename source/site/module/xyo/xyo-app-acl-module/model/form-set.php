<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setElementValue("id",$this->ds->id);
$this->setElementValue("xyo_module_id",$this->ds->xyo_module_id);
$this->setElementValue("xyo_module_group_id",$this->ds->xyo_module_group_id);
$this->setElementValue("xyo_core_id",$this->ds->xyo_core_id);
$this->setElementValue("xyo_user_group_id",$this->ds->xyo_user_group_id);
$this->setElementValue("enabled",$this->ds->enabled);
$this->setElementValue("order",$this->ds->order);
