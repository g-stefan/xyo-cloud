<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$isRequired = $this->getArgument("required", false);
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
	$classReadonly=" --readonly";
}else{
	$readonly="";
};

?>

<label class="xui-form-label<?php if($this->isElementError($element)){echo " xui --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<?php if($isRequired) { ?>
<div class="xui-form-textarea --required<?php if($this->isElementError($element)){echo " --danger";}; echo $classReadonly; ?>">
	<textarea<?php echo $maxlength; ?>
		rows="4"
		name="<?php $this->eElementName($element); ?>"
		id="<?php $this->eElementId($element); ?>" <?php echo $readonly; ?> ><?php echo $this->getElementValue($element); ?></textarea>
</div>
<?php } else { ?>
<textarea<?php echo $maxlength; ?> class="xui-form-textarea<?php if($this->isElementError($element)){echo " --danger";}; echo $classReadonly; ?>"
	rows="4"
	name="<?php $this->eElementName($element); ?>"
	id="<?php $this->eElementId($element); ?>" <?php echo $readonly; ?> ><?php echo $this->getElementValue($element); ?></textarea>
<?php }; ?>
<br>