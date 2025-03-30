<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if($this->elementValueStringIsEmpty("name")){
	return;
};

if($this->dsElementValueStringExists("name")){
	return;
};

if(!$this->dsPrimaryKeyLoad()){
	return;
};

$this->ds->name = $this->getElementValueString("name");
$this->ds->description = $this->getElementValueString("description");
$this->ds->default = $this->getElementValueNumber("default");
$this->ds->enabled = $this->getElementValueNumber("enabled");

if ($this->ds->save()) {

	if($this->ds->default){
		$id=$this->ds->id;
		$this->ds->clear();
		$this->ds->update(array("default"=>0));
		$this->ds->clear();
		$this->ds->id=$id;
		$this->ds->default=1;
		$this->ds->save();
	};
    
} else {
	$this->setError("error.save");
};

		