<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->processModel("form-default");
$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
if ($this->ds->load(0, 1)) {
	$this->processModel("form-set");	
} else {
	$this->setError("error.form_load");
	return;
};
