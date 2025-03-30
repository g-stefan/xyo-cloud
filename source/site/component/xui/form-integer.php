<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$isRequired = $this->getArgument("required", false);

$this->ecssBegin();
echo ".-form-integer{width:180px;}";
$this->ecssEnd();

?>

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<?php if($isRequired) { ?>
<div class="xui-form-text --required --compact <?php if($this->isElementError($element)){echo " --danger";}; ?>">
<input type="text" maxlength="12" placeholder="" class="-form-integer"
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
</div>
<?php } else { ?>
<input type="text" maxlength="12" class="xui-form-text<?php if($this->isElementError($element)){echo " --danger";}; ?> -form-integer" placeholder=""
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" ></input>
<?php }; ?>
<br>