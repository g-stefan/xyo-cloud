<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->isInline=true;
$this->setFormName($this->getFormName()."_edit");
$this->doActionBase("form-edit-apply");
$this->doRedirect(null);
$this->setViewTemplate(null);
if($this->isError()){
	$this->setView("table-inline-edit");
}else{
	$this->setView("table-inline-edit-close");
};
