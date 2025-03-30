<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

foreach ($this->viewData as $key => $value) {

	if (!$this->viewData[$key]["core_name"]) {
		$this->viewData[$key]["core_name"] = "*";
	};

	$dsAclCheck=&$this->getDataSource($this->applicationDataSource);
	$dsAclCheck->module_group_name="system-run";
	$dsAclCheck->xyo_module_id=$this->viewData[$key]["xyo_module_id"];
	$dsAclCheck->xyo_core_id=$this->viewData[$key]["xyo_core_id"];
	$dsAclCheck->enabled=1;
	if($dsAclCheck->load(0,1)){
		$this->viewData[$key]["active"]=1;
	};
};
