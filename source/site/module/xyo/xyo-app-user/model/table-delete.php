<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$dsUserXUserGroup=&$this->getDataSource("db.table.xyo_user_x_user_group");

$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
for ($this->ds->load(); $this->ds->isValid(); $this->ds->loadNext()) {

	if ($this->ds->{$this->primaryKey} == $this->user->info->id) {
		$this->setError("error.delete_this_user");
		continue;
	};
        
	if($dsUserXUserGroup){
		$dsUserXUserGroup->clear();
		$dsUserXUserGroup->xyo_user_id=$this->ds->id;
		$dsUserXUserGroup->delete();
	};
        
	$this->ds->delete();
};

if (!$this->isError()) {
	$this->setAlert("info.delete_ok");
};
