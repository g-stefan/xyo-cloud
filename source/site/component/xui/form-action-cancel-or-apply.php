<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
$onClickCancel = $this->getArgument("clickCancel","return false;");
$onClickApply = $this->getArgument("clickApply","this.form.submit();");

$uidCancel = $this->getUID();
$uidApply = $this->getUID();

$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uidCancel."\").onclick=function(){".$onClickCancel."};");
$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uidApply."\").onclick=function(){".$onClickApply."};");

?>
<div class="xui-form-separator"></div>
<button type="button" class="xui-button --secondary --outline float-left" tabindex="0" id="<?php echo $uidCancel; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_cancel"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<button type="button" class="xui-button --primary float-right" tabindex="0" id="<?php echo $uidApply; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_apply"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<div class="clear-both h-4"></div>