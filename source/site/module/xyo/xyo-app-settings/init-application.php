<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"material-icons\">settings_applications</i>");
$this->setApplicationDataSource("db.table.xyo_settings");

$this->setDefaultAction($this->getRequest("action", "form-edit"));
