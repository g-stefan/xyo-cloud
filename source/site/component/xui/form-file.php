<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");

?>
<label class="xui form-label<?php if($this->isElementError($element)){echo " -danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui form-file" style="width:100%;display:block;" id="<?php $this->eElementId($element); ?>_super">
<input type="file" name="<?php $this->eElementName($element); ?>" id="<?php $this->eElementId($element); ?>" class="xui _file"></input>
<label for="<?php $this->eElementId($element); ?>" class="xui button -icon-left -outline"><i class="material-icons">file_upload</i><span>Browse ...</span></label>
<button type="button" class="xui button -icon -info" onclick="document.getElementById('<?php $this->eElementId($element); ?>').value=null;$('#<?php $this->eElementId($element); ?>').trigger('change');"><i class="material-icons">delete</i></button>
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
<div class="xui separator"></div>
<?php

$this->eJsSourceAjax("XUI.FormFile.initElementById(\"".$this->getElementId($element)."_super\");");
