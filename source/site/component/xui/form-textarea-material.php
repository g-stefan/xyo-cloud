<?php
// Copyright (c) 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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

<div class="xui form-text -material<?php if($this->isElementError($element)){echo " -danger";}; echo $classReadonly; ?>">
<label for="<?php $this->eElementId($element); ?>"<?php if(strlen($this->getElementValue($element, ""))>0){ echo " class=\"xui -has-value\""; }?>><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<textarea<?php echo $maxlength; ?> 
	rows="4"
	name="<?php $this->eElementName($element); ?>"
	id="<?php $this->eElementId($element); ?>" <?php echo $readonly; ?> ><?php echo $this->getElementValue($element); ?></textarea>
</div>
<div class="xui separator"></div>
