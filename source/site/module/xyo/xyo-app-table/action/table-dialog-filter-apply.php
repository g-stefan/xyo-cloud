<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->isDialog=true;
$this->setFormName($this->getFormName()."_filter");
$this->doRedirect(null);
$this->setViewTemplate(null);
$this->processModel("table-view");
if($this->isError()){
	$this->setView("table-dialog-filter");
}else{
	$this->setView("table-dialog-filter-close");
};
