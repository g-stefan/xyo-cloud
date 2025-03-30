<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$isRequired = $this->getArgument("required", false);
$maxlength= 1*$this->getArgument("maxlength");
$autocomplete = $this->getArgument("autocomplete");

if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};

if(!is_null($autocomplete)){
	$autocomplete=" autocomplete=\"".$autocomplete."\"";
}else{
	$autocomplete="";
};

$isRequiredClass = "";
if($isRequired){
	$isRequiredClass = " --required";
};

?>

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui-form-text --icon-left<?php echo $isRequiredClass; if($this->isElementError($element)){echo " --danger";}; ?>">
<input type="password"<?php echo $maxlength; ?> placeholder="" <?php echo $autocomplete; ?>
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
<i class="lucide-lock"></i>
</div>
<br>