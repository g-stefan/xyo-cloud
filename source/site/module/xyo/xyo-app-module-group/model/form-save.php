<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if($this->elementValueStringIsEmpty("name")){
	return;
};

if($this->dsElementValueStringExists("name")){
	return;
}

if(!$this->dsPrimaryKeyLoad()){
	return;
};

$this->ds->name = $this->getElementValueString("name");
$this->ds->description = $this->getElementValueString("description");
$this->ds->enabled = $this->getElementValueNumber("enabled");

if (!$this->ds->save()) {
	$this->setError("error.save");
	return;
};
