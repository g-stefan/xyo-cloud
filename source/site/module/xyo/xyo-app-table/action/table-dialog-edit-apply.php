<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->isDialog=true;
$this->setFormName($this->getFormName()."_edit");
$this->doActionBase("form-edit-apply");
$this->doRedirect(null);
$this->setViewTemplate(null);
if($this->isError()){
	$this->setView("table-dialog-edit");
}else{
	$this->setView("table-dialog-edit-close");
};
