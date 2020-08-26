<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$maxlength= 1*$this->getArgument("maxlength");

if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};

?>

<div class="xui form-text -material<?php if($this->isElementError($element)){echo " -danger";}; ?>" style="width:100%">
<label for="<?php $this->eElementId($element); ?>"<?php if(strlen($this->getElementValue($element, ""))>0){ echo " class=\"xui -has-value\""; }?>><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<input type="text"<?php echo $maxlength; ?> placeholder=""
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
</div>
<div class="xui separator"></div>