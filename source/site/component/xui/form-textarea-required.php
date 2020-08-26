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

<label class="xui form-label<?php if($this->isElementError($element)){echo " xui -danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui form-text -required<?php if($this->isElementError($element)){echo " -danger";}; ?>">
	<textarea<?php echo $maxlength; ?>
		rows="4"
		name="<?php $this->eElementName($element); ?>"
		id="<?php $this->eElementId($element); ?>"><?php $this->eElementValue($element); ?></textarea>
</div>
<br>