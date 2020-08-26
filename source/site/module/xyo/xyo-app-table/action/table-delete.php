<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->processModel("set-primary-key-value");

if(is_array($this->primaryKeyValue)){
	if(count($this->primaryKeyValue)==0){
		$this->doRedirect("table-view");
		return;
	};
}else{
	if($this->primaryKeyValue==0){
		$this->doRedirect("table-view");
		return;
	};
};

$this->processModel("set-ds");
if (!$this->isError()) {
	$this->processModel("table-delete");
};

$this->doRedirect("table-view");
