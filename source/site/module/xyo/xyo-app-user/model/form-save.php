<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->elementValueStringIsEmpty("name");
$this->elementValueStringIsEmpty("username");

if($this->isNew){
	$this->elementValueStringIsEmpty("password1");
	$this->elementValueStringIsEmpty("password2");
};

$password1 = $this->getElementValueString("password1");
$password2 = $this->getElementValueString("password2");

if (strlen($password1) || strlen($password2)) {
	if ($password1 !== $password2) {
		$this->setElementErrorFromLanguage("password1", "does_not_match");
		$this->setElementErrorFromLanguage("password2", "does_not_match");
	};
};

if ($this->isElementError()) {
	if (!$this->isNew) {
		$this->ds->clear();
		$this->ds->id = $this->primaryKeyValue;
		if ($this->ds->load(0, 1)) {
			$this->processComponent("xui.form-image",array(
			"element" => "picture",
			"filename"=>"repository/xyo-user/".$this->ds->id."-".urlencode($this->ds->username)."-picture-".time(),
			"extension"=>true,
			"delete_before_save"=>true));
		};
	};
	return;
};

if($this->dsElementValueStringExists("username")){
	return;
};

if(!$this->dsPrimaryKeyLoad()){
	return;
};

$isAdministrator=($this->user->isInGroup("wheel")||$this->user->isInGroup("administrator"));

if($isAdministrator){ 
	$username = $this->getElementValueString("username");
	if (!$this->isNew) {
		if(strcmp($this->ds->username,$username)!=0){
			$this->ds->password=$this->user->changePasswordHashUsername($username,$this->ds->username,$this->ds->password,$this->cloud->get("user_password_encoding","hash"));
		};
	};

	$this->ds->name = $this->getElementValueString("name");
	$this->ds->username = $username;
	if ($this->isNew) {
		$this->ds->created_at = "NOW";
		$this->ds->password = $this->user->setPasswordHash($username,$password1,$this->cloud->get("user_password_encoding","hash"));
	} else {
		if (strlen($password1)) {
			$this->ds->password = $this->user->setPasswordHash($username,$password1,$this->cloud->get("user_password_encoding","hash"));
		};
	};
} else {
	if ($this->isNew) {
		$this->setError("error.save");
		return;
	};
	$username = $this->ds->username;
	if (strlen($password1)) {
		$this->ds->password = $this->user->setPasswordHash($username,$password1,$this->cloud->get("user_password_encoding","hash"));
	};
}

$this->ds->xyo_language_id = $this->getElementValueNumber("xyo_language_id");
$this->ds->enabled = $this->getElementValueNumber("enabled");
$this->ds->email = $this->getElementValueString("email");
$this->ds->description = $this->getElementValueString("description");
$this->ds->invisible = $this->getElementValueNumber("invisible");

if (1 * $this->ds->enabled == 0) {
	if ($this->ds->id == $this->user->info->id) {
		$this->setError("error.disable_this_user");
		$this->ds->enabled = 1;
	};
};
            
if ($this->ds->save()) {
	if($this->isInlineForm) {
		$this->setApplicationTitle($this->getFromLanguage("application.title") . " - " . $this->ds->name);
	};

	$this->processComponent("xui.form-image",array(
	"element" => "picture",
	"filename"=>"repository/xyo-user/".$this->ds->id."-".urlencode($this->ds->username)."-picture-".time(),
	"extension"=>true,
	"delete_before_save"=>true,
	"make_thumbnails" => array(
		array(128,128)
	)));
	$this->ds->picture=$this->getElementValueString("picture");
	$this->ds->save();
	  
	if ($this->isNew) {
	$dsUserXUserGroup = &$this->getDataSource("db.table.xyo_user_x_user_group");
        	if ($dsUserXUserGroup) {
			$dsUserXUserGroup->clear();
			$dsUserXUserGroup->xyo_user_id = $this->ds->id;
			$dsUserXUserGroup->xyo_user_group_id = $this->getElementValueNumber("xyo_user_group_id");
			$dsUserXUserGroup->allow = 1;
			$dsUserXUserGroup->enabled = 1;
			if (!$dsUserXUserGroup->save()) {
				$this->setError("error.new_user_x_user_group_save");
			};
		} else {
			$this->setError(array("error.datasource_not_found" => "db.table.xyo_user_x_user_group"));
		};
	};
    
	if($this->ds->id==$this->user->info->id){
		if (strlen($password1)) {
			if($this->user->reauthorizeUser()) {
				$this->user->setSessionScript();
			} else {
				$this->setError("error.save");
			};
		};
	};
    
	$this->setElementValue("password1","");
	$this->setElementValue("password2","");
    
	// ---

	$this->processModel("embedded-xyo-app-user-x-user-group",array(
		"xyo_user_id"=>$this->ds->id
	));

	// ---

} else {
	$this->setError("error.save");
};

