<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if($this->elementValueStringIsEmpty("name")){
	return;
};

if($this->dsElementValueStringExists("name")){
	return;
};

if(!$this->dsPrimaryKeyLoad()){
	return;
};

$updateAcl=0;
if (!$this->isNew) {
	if($this->ds->name!=$this->getElementValueString("name")){
		$updateAcl=1;		
	};
};

$this->ds->name=$this->getElementValueString("name");
$this->ds->parent=$this->getElementValueString("parent");
$this->ds->path=$this->getElementValueString("path");
$this->ds->description=$this->getElementValueString("description");
$this->ds->enabled=$this->getElementValueNumber("enabled");

if($this->ds->save()) {

	if($updateAcl) {
		$dsAclModule=&$this->getDataSource("db.table.xyo_acl_module");
		if($dsAclModule) {
			$dsAclModule->xyo_module_id=$this->ds->id;
			for($dsAclModule->load(); $dsAclModule->isValid(); $dsAclModule->loadNext()) {
				$dsAclModule->module=$this->ds->name;
				$dsAclModule->save();
			};
		};
	};

	if($this->isNew) {
		@mkdir($this->cloud->getStoragePath($name,0777,true));
		@copy($this->path."index.html",$this->cloud->getStorageFilename($name,"index.html"));

		$dsAclModule=&$this->getDataSource("db.table.xyo_acl_module");
		if($dsAclModule) {
			$dsAclModule->xyo_module_id=$this->ds->id;
			$dsAclModule->module=$this->ds->name;

			$dsAclModule->xyo_module_group_id = $this->getElementValueNumber("xyo_module_group_id");
			$dsAclModule->xyo_core_id = $this->getElementValueNumber("xyo_core_id");
			$dsAclModule->xyo_user_group_id = $this->getElementValueNumber("xyo_user_group_id");

			$dsAclModule->enabled = $this->getElementValueNumber("acl_enabled");
			$dsAclModule->order = $this->getElementValueNumber("order");

			$dsAclModule->save();
		};
	};

} else {
	$this->setError("error.save");
	return;
};

