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
$disabled = $this->getArgument("disabled","");
$readonly = $this->getArgument("readonly","");

if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};

$classDisabled="";
if(($disabled == 1) ||  ($disabled == "true")){
	$disabled=" disabled=\"disabled\"";
	$classDisabled=" -disabled";
}else{
	$disabled="";
};

$classReadonly="";
if(($readonly == 1) ||  ($readonly == "true")){
	$readonly=" readonly=\"readonly\"";
	$classReadonly=" -readonly";
}else{
	$readonly="";
};

?>

<label class="xui form-label<?php if($this->isElementError($element)){echo " -danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui form-text -required<?php if($this->isElementError($element)){echo " -danger";}; echo $classDisabled; echo $classReadonly; ?>" style="width:100%">
<input type="text"<?php echo $maxlength; ?> placeholder="" style="width:100%" required="required" <?php echo $disabled; ?> <?php echo $readonly; ?>
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
</div>
<br>
