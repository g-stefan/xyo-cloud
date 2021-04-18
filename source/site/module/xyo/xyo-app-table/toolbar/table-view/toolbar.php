<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setItem("delete", "item-js.important", "<i class=\"material-icons\">delete</i>", "delete", "danger".($this->isEmbedded?" -only-icon":""), "#", $this->instanceV."cmdDialogDelete()");
$this->setItem("edit", "item-js.important", "<i class=\"material-icons\">create</i>", "edit", "success".($this->isEmbedded?" -only-icon":""), "#", $this->instanceV."cmdDialogEdit()");
$this->setItem("new", "item-js.important", "<i class=\"material-icons\">add</i>", "new", "primary", "#", $this->instanceV."cmdDialogNew()");

$filterToolbarButton=$this->getParameter("filter_toolbar_button",false);
if($filterToolbarButton){

	$this->setItem("separator-filter","separator",null,null,null,null,null);	

	$this->setItem("filter",
	        "item-js.important",
	        "<i class=\"material-icons\">filter_list</i>",
	        "filter",
        	"info".($this->isEmbedded?" -only-icon":""),
	        "#",
        	$this->instanceV."cmdDialogFilter()"
	);
};
