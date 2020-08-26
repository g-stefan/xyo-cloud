<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$order = trim($this->getRequestInstance("order"));
if (!strlen($order)) {
	return;
};

$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
if ($this->ds->load(0, 1)) {
	$value = $this->ds->$order;
	$valueUp = ($value - 1);
	if ($valueUp < 1) {
		$valueUp = 1;
	};

	if (!($value == $valueUp)) {
		$this->ds->clear();
		$this->ds->$order = $valueUp;
		if ($this->ds->load(0, 1)) {
			$this->ds->$order = $this->ds->$order + 1;
			$this->ds->save();
       		};
		$this->ds->clear();
		$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
		if ($this->ds->load(0, 1)) {
			$this->ds->$order = $valueUp;
			$this->ds->save();
       		};
	};
};
