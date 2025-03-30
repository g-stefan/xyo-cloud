<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$uid = $this->getUID();

$this->ecssBegin();
echo ".--form-file{width:100%;display:block;}";
$this->ecssEnd();

?>
<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui-form-file --form-file" id="<?php $this->eElementId($element); ?>_super">
<input type="file" name="<?php $this->eElementName($element); ?>" id="<?php $this->eElementId($element); ?>" class="xui-form-file_input"></input>
<label for="<?php $this->eElementId($element); ?>" class="xui-button --icon-left --outline"><i class="lucide-upload"></i><span>Browse ...</span></label>
<button type="button" class="xui-button --icon --outline --secondary" id="<?php echo $uid; ?>" ><i class="lucide-x"></i></button>
</div>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_delete"
	value="0"
	id="<?php $this->eElementId($element); ?>_delete" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_value"
	value="<?php $this->eElementValue($element); ?>" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_file"
	value="<?php $this->eElementValue($element); ?>" ></input>
<div class="clear-both h-4"></div>
<?php

$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uid."\").onclick=function(){".
	"document.getElementById(\"".$this->getElementId($element)."\").value=null;".
	"$(\"#".$this->getElementId($element)."\").trigger(\"change\");".
"};");
$this->eJsSourceAjax("XUI.FormFile.initElementById(\"".$this->getElementId($element)."_super\");");
