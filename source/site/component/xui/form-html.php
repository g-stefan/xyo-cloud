<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$maxlength= 1*$this->getArgument("maxlength");

if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};

$this->eJsSourceAjax("XUI.FormHtml.initById(\"".($this->getElementId($element))."\");");

$this->ecssBegin();
echo ".-form-html._content{min-height:240px;}";
echo ".-form-html._value{display:none;}";
$this->ecssEnd();
?>

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui-form-html<?php if($this->isElementError($element)){echo " --danger";}; ?>" id="<?php $this->eElementId($element); ?>">
	<div class="xui-form-html_content -form-html"><?php echo $this->getElementValue($element); ?></div>
	<textarea <?php echo $maxlength; ?> class="xui-form-html_value -form-html"
	name="<?php $this->eElementName($element); ?>"
	id="<?php $this->eElementId($element); ?>_html"><?php echo $this->getElementValue($element); ?></textarea>
<br>