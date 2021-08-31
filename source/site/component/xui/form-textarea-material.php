<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$maxlength= 1*$this->getArgument("maxlength");
$readonly = $this->getArgument("readonly","");

if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};

$classReadonly="";
if(($readonly == 1) ||  ($readonly == "true")){
	$readonly=" readonly=\"readonly\"";
	$classReadonly=" -readonly";
}else{
	$readonly="";
};

?>

<div class="xui form-text -material<?php if($this->isElementError($element)){echo " -danger";}; echo $classReadonly; ?>" style="width:100%">
<label for="<?php $this->eElementId($element); ?>"<?php if(strlen($this->getElementValue($element, ""))>0){ echo " class=\"xui -has-value\""; }?>><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<textarea<?php echo $maxlength; ?> 
	rows="4"
	name="<?php $this->eElementName($element); ?>"
	id="<?php $this->eElementId($element); ?>" <?php echo $readonly; ?> ><?php echo $this->getElementValue($element); ?></textarea>
</div>
<div class="xui separator"></div>
