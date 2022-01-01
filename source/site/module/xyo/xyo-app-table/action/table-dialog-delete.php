<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->tableIsDelete=true;
$this->isDialog=true;
$this->processModel("set-primary-key-value");
$this->processModel("table-view");
$this->processModel("table-view-process");
$this->setViewTemplate(null);
$this->setView("table-dialog-delete");
