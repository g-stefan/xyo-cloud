<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->isNew = false;
$this->processModel("set-primary-key-value-one");
$this->processModel("set-ds");

if (!$this->isError()) {
	$this->clearElementError();
	$this->processModel("form-edit-save");
};

$this->setParameter("toolbar", "toolbar/form-edit");
$this->processModel("form-edit");
$this->setView("form-edit");
