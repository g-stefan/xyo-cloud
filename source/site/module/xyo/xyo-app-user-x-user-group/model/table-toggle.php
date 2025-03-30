<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$toggle = trim($this->getRequestInstance("toggle"));
if (!strlen($toggle)) {
	return;
};

if ($toggle=="principal") {
	$this->ds->clear();
	$this->ds->{$this->primaryKey} = $this->primaryKeyValue;	
	if($this->ds->load(0,1)){
		$dsx=&$this->ds->copyThis();
		$dsx->clear();
		$dsx->xyo_user_id=$this->ds->xyo_user_id;
		$dsx->update(array("principal"=>0));
		$this->ds->principal=1;
		$this->ds->save();
	};
	return;
};

$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
for ($this->ds->load(); $this->ds->isValid(); $this->ds->loadNext()) {
	$value = $this->ds->$toggle;
	if (1 * $value) {
		$value = 0;
	} else {
		$value = 1;
	};
	$this->ds->$toggle = $value;
	$this->ds->save();
};
