<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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
