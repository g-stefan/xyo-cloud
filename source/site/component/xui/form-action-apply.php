<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
$uid = $this->getUID();
$onClickApply = $this->getArgument("click","this.form.submit();");

$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uid."\").onclick=function(){".$onClickApply."};");

?><div class="xui-form-separator"></div>
<button type="button" class="xui-button --primary float-right" tabindex="0" id="<?php echo $uid; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_apply"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<div class="clear-both h-4"></div>