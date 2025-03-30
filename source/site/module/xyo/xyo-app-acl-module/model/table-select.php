<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if($this->xyo_module_id){
	$this->ds->xyo_module_id=$this->xyo_module_id;
};

if($this->xyo_module_group_id){
	$this->ds->xyo_module_group_id=$this->xyo_module_group_id;
};

if(!$this->ds->isEmpty($this->ds->xyo_core_id)){
	if(is_array($this->ds->xyo_core_id)) {
		$this->ds->xyo_core_id=array_merge(array(0),$this->ds->xyo_core_id);
	} else {
		$this->ds->xyo_core_id=array(0,$this->ds->xyo_core_id);
	};
};

if(!$this->ds->isEmpty($this->ds->xyo_user_group_id)){
	if(is_array($this->ds->xyo_user_group_id)) {
		$this->ds->xyo_user_group_id=array_merge(array(0),$this->ds->xyo_user_group_id);
	} else {
		$this->ds->xyo_user_group_id=array(0,$this->ds->xyo_user_group_id);
	};
};

$this->ds->setGroup("id",true);
$this->ds->setGroup("module_name",true);
$this->ds->setGroup("module_group_name",true);
$this->ds->setGroup("core_name",true);
$this->ds->setGroup("user_group_name",true);
