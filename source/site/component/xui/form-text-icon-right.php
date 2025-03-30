<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$isRequired = $this->getArgument("required", false);
$maxlength= 1*$this->getArgument("maxlength");
$icon = $this->getArgument("icon","<i class=\"lucide-circle\"></i>");
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

$isRequiredClass = "";
if($isRequired){
	$isRequiredClass = " --required";
};

?>

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui-form-text --icon-right<?php echo $isRequiredClass; if($this->isElementError($element)){echo " --danger";}; echo $classReadonly; ?>">
<input type="text"<?php echo $maxlength; ?> placeholder="" <?php echo $readonly; ?>
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
<?php echo $icon; ?>
</div>
<br>