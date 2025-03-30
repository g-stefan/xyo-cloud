<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setItem("delete", "item-js.important", "<i class=\"lucide-x\"></i>", "delete", "danger".($this->isEmbedded?" --only-icon":""), "#", $this->instanceV."cmdDialogDelete()");
$this->setItem("edit", "item-js.important", "<i class=\"lucide-pen\"></i>", "edit", "success".($this->isEmbedded?" --only-icon":""), "#", $this->instanceV."cmdDialogEdit()");
$this->setItem("new", "item-js.important", "<i class=\"lucide-plus\"></i>", "new", "primary", "#", $this->instanceV."cmdDialogNew()");

$filterToolbarButton=$this->getParameter("filter_toolbar_button",false);
if($filterToolbarButton){

	$this->setItem("separator-filter","separator",null,null,null,null,null);	

	$this->setItem("filter",
	        "item-js.important",
	        "<i class=\"lucide-list-filter\"></i>",
	        "filter",
        	"info".($this->isEmbedded?" --only-icon":""),
	        "#",
        	$this->instanceV."cmdDialogFilter()"
	);
};
