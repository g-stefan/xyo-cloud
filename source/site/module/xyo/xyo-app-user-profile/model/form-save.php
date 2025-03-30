<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if($this->isNew){
	$this->setError("error.save");
	return;
};

$this->elementValueStringIsEmpty("name");
$this->elementValueStringIsEmpty("username");

$password1 = $this->getElementValueString("password1");
$password2 = $this->getElementValueString("password2");

if (strlen($password1) || strlen($password2)) {
	if ($password1 !== $password2) {
		$this->setElementErrorFromLanguage("password1", "does_not_match");
		$this->setElementErrorFromLanguage("password2", "does_not_match");
	};
};

if ($this->isElementError()) {
	$this->ds->clear();
	$this->ds->id = $this->primaryKeyValue;
	if ($this->ds->load(0, 1)) {
		$this->processComponent("xui.form-image",array(
		"element" => "picture",
		"filename"=>"repository/xyo-user/".$this->ds->id."-".$this->ds->username."-picture-".time(),
		"extension"=>true,
		"delete_before_save"=>true));
	};
	return;
};

if($this->elementValueStringIsEmpty("username")){
	return;
};

if(!$this->dsPrimaryKeyLoad()){
	return;
};

$isAdministrator=($this->user->isInGroup("wheel")||$this->user->isInGroup("administrator"));

if($isAdministrator) {
	$username = $this->getElementValueString("username");
	if(strcmp($this->ds->username,$username)!=0){
		$this->ds->password = $this->user->changePasswordHashUsername($username, $this->ds->username, $this->ds->password, $this->cloud->get("user_password_encoding","hash"));
	};

	$this->ds->name = $this->getElementValueString("name");
	$this->ds->username = $username;	
} else {	
	$username=$this->ds->username;
};

if (strlen($password1)) {
	$this->ds->password = $this->user->setPasswordHash($username,$this->getElementValue("password1"),$this->cloud->get("user_password_encoding","hash"));
};

$this->ds->xyo_language_id = $this->getElementValueNumber("xyo_language_id");
$this->ds->description = $this->getElementValueString("description");
$this->ds->email = $this->getElementValueString("email");

if ($this->ds->save()) {

	$this->processComponent("xui.form-image",array(
		"element" => "picture",
		"filename"=>"repository/xyo-user/".$this->ds->id."-".$this->ds->username."-picture-".time(),
		"extension"=>true,
		"delete_before_save"=>true,
		"make_thumbnails" => array(
			array(128,128)
		)));
	$this->ds->picture=$this->getElementValueString("picture");
	$this->ds->save();

    
	if($this->ds->id==$this->user->info->id) {
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
    
} else {
	$this->setError("error.save");
};
