<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->isDialog=true;
$this->setFormName($this->getFormName()."_new");
$this->doActionBase("form-new-apply");
$this->setViewTemplate(null);
$this->doRedirect(null);
if($this->isError()){
	$this->setView("table-dialog-new");
}else{
	$this->setView("table-dialog-new-close");
};
