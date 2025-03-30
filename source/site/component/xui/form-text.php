<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$isRequired = $this->getArgument("required", false);
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
	$classDisabled=" --disabled";
}else{
	$disabled="";
};

$classReadonly="";
if(($readonly == 1) ||  ($readonly == "true")){
	$readonly=" readonly=\"readonly\"";
	$classReadonly=" --readonly";
}else{
	$readonly="";
};

?>

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<?php if($isRequired) { ?>
<div class="xui-form-text --required<?php if($this->isElementError($element)){echo " --danger";}; echo $classDisabled; echo $classReadonly; ?>">
<input type="text"<?php echo $maxlength; ?> placeholder="" required="required" <?php echo $disabled; ?> <?php echo $readonly; ?>
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
</div>
<?php } else { ?>
<input type="text"<?php echo $maxlength; ?> class="xui-form-text<?php if($this->isElementError($element)){echo " --danger";}; echo $classDisabled; echo $classReadonly; ?>" placeholder="" <?php echo $disabled; ?> <?php echo $readonly; ?>
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
<?php } ?>
<br>