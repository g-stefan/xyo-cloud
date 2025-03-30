<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

// allow captcha image generator, the CSRF Token is reset on login
$this->csrfReset();
$this->setCsrfReferenceCount(2); 
// ---

$languageSelector=$this->cloud->get("login_has_select_language",0);
if($languageSelector==1){
	$languageSelector=!$this->getModuleSetting("no_language_selector",0);
};

if($languageSelector){

	$language = $this->getSystemLanguage();
	$languageList = array();
	$languageList["*"] = $this->getFromLanguage("lang_default");
	$dsLanguage = &$this->getDataSource("db.table.xyo_language");
	if ($dsLanguage) {
		$dsLanguage->enabled = 1;
		$dsLanguage->setOrder("name", 1);
		for ($dsLanguage->load(); $dsLanguage->isValid(); $dsLanguage->loadNext()) {
			$languageList[$dsLanguage->name] = $dsLanguage->description;
		};
	};

	$this->setParameter("select.language",$languageList);
};

$rnd=$this->getElementValueString("rnd","");
if(strlen($rnd)<strlen(hash("sha512","x",true))){
	$rnd=hash("sha512",date("Y-m-d H:i:s")." - ".rand(),false);
	$this->setElementValue("rnd",$rnd);
};
$salt=hash("sha512",$rnd.".".$this->cloud->get("user_login_salt", "unknown"),false);

$parameters=array("user_authorization"=>"true");

$sysCaptcha=$this->cloud->get("user_captcha", false);

$useCaptcha=false;
if($sysCaptcha){
	if ($this->isError()) {
		$useCaptcha=true;
		$_SESSION["user_captcha_force"]=1;
	}else{
		if(array_key_exists("user_captcha_force",$_SESSION)){
			$useCaptcha=true;
		}else{
			$captcha=hash("sha512",date("Y-m-d H:i:s")." - ".rand(),false);	
			$_SESSION["user_captcha_rnd"]=$rnd;
			$_SESSION["user_captcha_key"]=hash("sha512",$rnd.hash("sha512",$captcha,false),false);
			$parameters=array_merge($parameters,array("user_captcha"=>$captcha));
		};
	};
};

if ($this->isError()) {
	$msg_lang = $this->getFromLanguage("error.unknown");
};

$this->generateComponent("xui.form-action-begin",array("attributes"=>array("data-salt"=>$salt)));
$this->generateComponent("xui.box-1x1-begin");
$this->generateComponent("xui.panel-begin",array("title"=>"title.login","css-class"=>"shadow-md"));

$this->generateComponent("xui.form-username", array("element" => "username","required"=>true));
$this->generateComponent("xui.form-password", array("element" => "password","required"=>true));

if($languageSelector){
	$this->generateComponent("xui.form-select", array("element" => "language","on_change"=>"if(xyoFormLoginAction(this.form)){this.form.submit();};"));
};

if($useCaptcha){
	$this->generateComponent("xui.form-captcha",array("element"=>"captcha", "prefix"=>"user", "rnd"=>$rnd));	
};

echo "<div class=\"clear-both h-5\"></div>";

$this->ecssBegin();
echo ".--default.--div-1{display:block;text-align:center;}";
$this->ecssEnd();

?>

<br />
<div class="--default --div-1">
	<input type="submit" class="xui-button --primary" name="<?php $this->eElementName("login"); ?>" value="<?php $this->eLanguage("cmd_login"); ?>" ></input>
</div>

<?php

echo "<div class=\"clear-both h-5\"></div>";

$this->generateComponent("xui.panel-end");
$this->generateComponent("xui.box-1x1-end");

$this->generateComponent("xui.form-hidden",array("element"=>"rnd"));
$this->generateComponent("xui.form-action-end",array("parameters"=>$parameters));

