<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");

$params=array();
$rnd = $this->getArgument("rnd","");
if($rnd) {
	$params=array_merge($params,array("rnd"=>$rnd));
};
$prefix = $this->getArgument("prefix","");
if($prefix) {
	$params=array_merge($params,array("prefix"=>$prefix));
};

$uid = $this->getUID();

?>
<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui-form-captcha">
	<img id="<?php $this->eElementId($element); ?>_image" src="<?php echo $this->requestUriModule("xui-image-captcha",array_merge($params,array("stamp"=>md5(time().rand())))); ?>"></img>
	<div class="xui-form-input-group">
	<input type="text" placeholder=""
		value="<?php $this->eElementValue($element, ""); ?>"
		name="<?php $this->eElementName($element); ?>"
		id="<?php $this->eElementId($element); ?>" ></input>
	<button type="button" id="<?php echo $uid; ?>"><i class="lucide-refresh-cw"></i></button>
	</div>
</div>
<?php

$id=$this->getElementId($element);
$source="document.getElementById(\"".$uid."\").onclick=function(){";
$source.="var el=document.getElementById(\"".$id."_image\");";
$source.="if(el){";
$source.=" el.src=\"".$this->requestUriModule("xui-image-captcha",$params)."&stamp=\"+Math.random();";
$source.="};";
$source.="return false;";
$source.="};";
$this->setHtmlJsSource($source,"load");

