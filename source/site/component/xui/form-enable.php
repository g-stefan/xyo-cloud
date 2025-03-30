<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$select_list = array(
    "1" => $this->getFromLanguage("select.enabled_enabled"),
    "0" => $this->getFromLanguage("select.enabled_disabled")
);
$select_value = $this->getElementValue($element);
?>	

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<select class="xui-form-select<?php if($this->isElementError($element)){echo " --danger";}; ?>" name="<?php $this->eElementName($element); ?>" id="<?php $this->eElementId($element); ?>">
<?php
	foreach ($select_list as $key => $value) {
		$selected = "";
		if (strcmp($key, $select_value) == 0) {
			$selected = " selected=\"selected\"";
		}
		echo "<option value=\"" . $key . "\" " . $selected . ">" . $value . "</option>";
	}

?>
</select>
<br>