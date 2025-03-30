<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$connection=$this->getElementValueString("connection","*");
$datasource=$this->getElementValueString("name","*");
$option=$this->getElementValueString("option","*");

if(strlen($datasource)>0){
	if($datasource!="*"){
		if(strlen($option)>0){
			if($option!="*"){
				$ds=&$this->getDataSource($datasource);
				if ($ds) {
					if ($option == "create") {
						$ds->createStorage();
						$this->setAlert("datasource_create");
					} else
					if ($option == "recreate") {
						$ds->recreateStorage();
						$this->setAlert("datasource_recreate");
					} else
					if ($option == "destroy") {
						$ds->destroyStorage();
						$this->setAlert("datasource_destroy");
					};
				};
			};
		};
	};
};
