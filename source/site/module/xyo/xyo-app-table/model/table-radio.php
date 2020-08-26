<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$radio = trim($this->getRequestInstance("radio"));
if (!strlen($radio)) {
	return;
};

$this->ds->clear();
$this->ds->update(array($radio=>0));
$this->ds->clear();
$this->ds->{$this->primaryKey}=$this->primaryKeyValue;
$this->ds->$radio=1;
$this->ds->save();
