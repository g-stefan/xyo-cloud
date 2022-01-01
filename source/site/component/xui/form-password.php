<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
	$isRequiredClass = " -required";
};

?>

<label class="xui form-label<?php if($this->isElementError($element)){echo " -danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui form-text -icon-left<?php echo $isRequiredClass; if($this->isElementError($element)){echo " -danger";}; ?>" style="width:100%">
<input type="password"<?php echo $maxlength; ?> placeholder="" style="width:100%" <?php echo $autocomplete; ?>
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
<i class="material-icons">lock</i>
</div>
<br>