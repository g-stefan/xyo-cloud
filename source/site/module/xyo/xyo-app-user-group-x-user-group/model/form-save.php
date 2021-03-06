<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if(!$this->dsPrimaryKeyLoad()){
	return;
};

if($this->xyo_user_group_id_super){
	$this->ds->xyo_user_group_id_super=$this->xyo_user_group_id_super;
} else {
	$this->ds->xyo_user_group_id_super = $this->getElementValueNumber("xyo_user_group_id_super");
};

$this->ds->xyo_user_group_id = $this->getElementValueNumber("xyo_user_group_id");

if($this->isNew){
	$this->ds->tryLoad();
};

$this->ds->enabled = $this->getElementValueNumber("enabled");

if (!$this->ds->save()) {
	$this->setError("error.save");
	return;
};
