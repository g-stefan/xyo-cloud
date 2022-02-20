<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");
$onClickCancel = $this->getArgument("clickCancel","return false;");
$onClickApply = $this->getArgument("clickApply","this.form.submit();");

$uidCancel = $this->getUID();
$uidApply = $this->getUID();

$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uidCancel."\").onclick=function(){".$onClickCancel."};");
$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uidApply."\").onclick=function(){".$onClickApply."};");

?>
<div class="xui form-separator"></div>
<button type="button" class="xui button -secondary -outline -left" tabindex="0" id="<?php echo $uidCancel; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_cancel"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<button type="button" class="xui button -primary -right" tabindex="0" id="<?php echo $uidApply; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_apply"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<div class="xui separator"></div>