<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");
$onClickCancel = $this->getArgument("clickCancel","return false;");
$onClickApply = $this->getArgument("clickApply","this.form.submit();");
$onClickSave = $this->getArgument("clickSave","this.form.submit();");

?>
<div class="xui form-separator"></div>
<button type="button" class="xui button -secondary -outline -left" tabindex="0" onclick="<?php echo $onClickCancel; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_cancel"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<button type="button" class="xui button -primary -right" tabindex="0" onclick="<?php echo $onClickApply; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_apply"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<button type="button" class="xui button -success -right" style="margin-right:6px;" tabindex="0" onclick="<?php echo $onClickSave; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_save"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<div class="xui separator"></div>