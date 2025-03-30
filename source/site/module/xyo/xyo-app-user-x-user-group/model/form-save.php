<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if(!$this->dsPrimaryKeyLoad()){
	return;
};

if ($this->xyo_user_id) {
	$this->ds->xyo_user_id = $this->xyo_user_id;
} else {
	$this->ds->xyo_user_id = $this->getElementValueNumber("xyo_user_id");
};

$this->ds->xyo_user_group_id = $this->getElementValueNumber("xyo_user_group_id");
if ($this->isNew) {
	$this->ds->tryLoad();
};

$this->ds->principal = $this->getElementValueNumber("principal");
$this->ds->enabled = $this->getElementValueNumber("enabled");

if ($this->ds->save()) {

	if($this->ds->principal){
		$id=$this->ds->id;
		$this->ds->clear();
		$this->ds->xyo_user_id=$this->ds->xyo_user_id;
		$this->ds->update(array("principal"=>0));
		$this->ds->clear();
		$this->ds->id=$id;
		$this->ds->principal=1;
		$this->ds->save();
	};
    
} else {
	$this->setError("error.save");
	return;
};
