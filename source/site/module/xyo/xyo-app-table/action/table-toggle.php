<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->processModel("set-primary-key-value-one");
$this->processModel("set-ds");

if (!$this->isError()) {
	$this->processModel("table-toggle");
};

$this->doRedirect("table-view");
