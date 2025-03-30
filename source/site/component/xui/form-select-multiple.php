<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$isRequired = $this->getArgument("required", false);
$select_list = $this->getParameter("select." . $element);
$select_value = explode(",",$this->getElementValue($element));
$submit=$this->getArgument("submit",false);
$onChange=$this->getArgument("on_change",null);
$uid=$this->getElementId($element);

if($submit){
	$submit="this.form.submit();";
}else{
	$submit="";
};

if($onChange){
	$submit=$onChange;
};

$isRequiredClass="";
if($isRequired){
	$isRequiredClass=" --required";
};

if(strlen($submit)){
	$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uid."\").onchange=function(){".$submit."};");
};

?>	

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<select class="xui-form-select --multiple<?php echo $isRequiredClass; if($this->isElementError($element)){echo " --danger";}; ?>" name="<?php $this->eElementName($element); ?>" id="<?php $this->eElementId($element); ?>" multiple="multiple">
<?php
	foreach ($select_list as $key => $value) {
		$selected = "";
		if (strcmp($key, trim($select_value)) == 0) {
			$selected = " selected=\"selected\"";
		}
		echo "<option value=\"" . $key . "\" " . $selected . ">" . $value . "</option>";
	}

?>
</select>
<br>

<?php

if($this->isAjax()){
	$this->ejsBegin();
	echo "XUI.FormSelect.initById(\"".$this->getElementId($element)."\");";
	$this->ejsEnd();
};
