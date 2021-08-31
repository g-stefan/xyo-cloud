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

if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};

$this->eJsSourceAjax("XUI.FormHtml.initById(\"".($this->getElementId($element))."\");");

?>

<label class="xui form-label<?php if($this->isElementError($element)){echo " -danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui form-html<?php if($this->isElementError($element)){echo " -danger";}; ?>" id="<?php $this->eElementId($element); ?>">
	<div class="xui _content" style="min-height:240px;"><?php

	$htmlFile=$this->getElementValue($element);
	if(strlen($htmlFile)){
		echo file_get_contents($htmlFile);
	};

	?></div>
	<textarea <?php echo $maxlength; ?> class="xui _value" style="display:none;"
	name="<?php $this->eElementName($element); ?>_html"
	id="<?php $this->eElementId($element); ?>_html"><?php

	$htmlFile=$this->getElementValue($element);
	if(strlen($htmlFile)){
		echo file_get_contents($htmlFile);
	};

		?></textarea>
    <input type="hidden"
       name="<?php $this->eElementName($element); ?>_file"
       value="<?php $this->eElementValue($element); ?>" ></input>
</div>
<br>