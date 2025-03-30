<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$on = "";
if($this->getElementValueNumber($element)>0){
	$on = " checked ";
};

?>
<div class="xui-form-checkbox --switch <?php if($this->isElementError($element)){echo " --danger";}; ?>">
	<input type="checkbox"
	name="<?php $this->eElementName($element); ?>"
	value="1" <?php echo $on; ?>
	id="<?php $this->eElementId($element); ?>" ></input>
	<label for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
</div>
<br>