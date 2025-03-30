<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$toggle = trim($this->getRequestInstance("toggle"));
if (!strlen($toggle)) {
	return;
};

if(!($toggle=="active")){
	return;
};

$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
if($this->ds->load(0,1)){

	$dsAclCheck=&$this->ds->copyThis();
	$dsAclCheck->clear();
	$dsAclCheck->xyo_core_id=$this->ds->xyo_core_id;
	$dsAclCheck->module_group_name="template";
	$moduleList=array();
	for($dsAclCheck->load();$dsAclCheck->isValid();$dsAclCheck->loadNext()){
		if(!($dsAclCheck->xyo_module_id==$this->ds->xyo_module_id)){
			$moduleList[]=$dsAclCheck->xyo_module_id;
		};
	};

	if(count($moduleList)>0){

		$dsAclCheck->clear();
		$dsAclCheck->module_group_name=array("system-load","system-run");
		$dsAclCheck->xyo_core_id=$this->ds->xyo_core_id;
		$dsAclCheck->xyo_module_id=$moduleList;
		$dsAclCheck->update(array("enabled"=>0));

	};
	
	$dsAclCheck->clear();
	$dsAclCheck->module_group_name="system-load";
	$dsAclCheck->xyo_user_group_id=0;//all users
	$dsAclCheck->xyo_core_id=$this->ds->xyo_core_id;
	$dsAclCheck->xyo_module_id=$this->ds->xyo_module_id;
	$dsAclCheck->tryLoad(0,1);	
	$dsAclCheck->module=$this->ds->module_name;
	$dsAclCheck->enabled=1;
	$dsAclCheck->save();

	$dsAclCheck->clear();
	$dsAclCheck->module_group_name="system-run";
	$dsAclCheck->xyo_user_group_id=0;//all users 
	$dsAclCheck->xyo_core_id=$this->ds->xyo_core_id;
	$dsAclCheck->xyo_module_id=$this->ds->xyo_module_id;
	$dsAclCheck->tryLoad(0,1);	
	$dsAclCheck->module=$this->ds->module_name;
	$dsAclCheck->enabled=1;
	$dsAclCheck->save();

	// Load and change if this is the running core
	$currentCore=$this->cloud->get("core","");
	if(strlen($currentCore)){
		$dsCore=&$this->getDataSource("db.table.xyo_core");
		$dsCore->clear();
		$dsCore->name=$currentCore;
		$dsCore->enabled=1;
		if($dsCore->load(0,1)){
			if($this->ds->xyo_core_id==$dsCore->id){
				$this->cloud->forceTemplate($this->ds->module_name);
			};
		};
	};
	
};

