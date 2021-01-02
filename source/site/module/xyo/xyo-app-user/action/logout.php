<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->processModel("set-primary-key-value");
$this->processModel("set-ds");
if (!$this->isError()) {
	$this->processModel("logout");
};

$this->doRedirect("table-view");
