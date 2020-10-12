<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setParameter("toolbar", "toolbar/table-edit");
$this->isInline=true;
$this->isNew=false;
$this->setFormName($this->getFormName()."_edit");
$this->setViewTemplate(null);
$this->setView("toolbar");
