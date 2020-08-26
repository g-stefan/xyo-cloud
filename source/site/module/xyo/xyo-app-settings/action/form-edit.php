<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->isNew = false;
$this->setParameter("toolbar", "toolbar/form-edit");
$this->processModel("system-settings");
$this->processModel("set-ds");
$this->processModel("form-edit");
$this->setView("form-edit");
