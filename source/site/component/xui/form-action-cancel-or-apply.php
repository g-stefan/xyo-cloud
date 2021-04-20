<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");
$onClickCancel = $this->getArgument("clickCancel","return false;");
$onClick = $this->getArgument("click","this.form.submit();");

?>
<div class="xui form-separator"></div>
<button type="button" class="xui button -secondary -outline -left" onclick="<?php echo $onClickCancel; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_cancel"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<button type="button" class="xui button -primary -right" onclick="<?php echo $onClick; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("label.button_apply"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<div class="xui separator"></div>