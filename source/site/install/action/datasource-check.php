<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$allOk = true;
$this->setView("datasource");
$this->clearElementError();
$layer = $this->getElementValue("layer");

if ($layer === "mysqli" || $layer === "mysql" || $layer === "postgresql" ) {

	$server = $this->getElementValueString("server");
	if (strlen($server) == 0) {
		$this->setElementErrorFromLanguage("server", "is_empty");
	};

	$port = $this->getElementValueString("port");
	if (strlen($port) == 0) {		
		$port=0;
	};

	if(1*$port){}else{
		if($layer === "mysql"){
			$port="3306";
		};
		if($layer === "mysqli"){
			$port="3306";
		};
		if($layer === "postgresql"){
			$port="5432";
		};
	};

	$this->setElementValue("port",$port);
	

	$username = $this->getElementValueString("username");
	if (strlen($username) == 0) {
        	$this->setElementErrorFromLanguage("username", "is_empty");
	};

	$database = $this->getElementValueString("database");
	if (strlen($database) == 0) {
		$this->setElementErrorFromLanguage("database", "is_empty");
	};
};

if ($this->isError()) {
	$this->doRedirect("datasource");
} else {
	$this->processModel("datasource-config");
	$this->doRedirect("install");
};
