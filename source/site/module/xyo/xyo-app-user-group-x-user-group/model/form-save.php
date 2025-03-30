<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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
