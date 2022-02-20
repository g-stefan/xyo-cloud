<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");
$uid = $this->getUID();
$onClickApply = $this->getArgument("click","this.form.submit();");

$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uid."\").onclick=function(){".$onClickApply."};");

?><div class="xui form-separator"></div>
<button type="button" class="xui button -primary -right" tabindex="0" id="<?php echo $uid; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_apply"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<div class="xui separator"></div>