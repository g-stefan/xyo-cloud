<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$formTitle="form.title_select";
$layer=$this->getElementValueString("layer","xyo");

?>
<?php $this->ejsBegin(); ?>
    function doCommand(action){
        var el;
        var id;

        document.forms.<?php $this->eFormName(); ?>.elements.action.value=action;
	document.forms.<?php $this->eFormName(); ?>.elements.csrf_token.value=window.csrfToken;
        document.forms.<?php $this->eFormName(); ?>.submit();
        return false;
    }
    <?php $this->ejsEnd(); ?>

<form name="<?php $this->eFormName(); ?>" method="POST" action="<?php $this->eFormAction(); ?>" class="xui-application-main-form">

<?php

$this->eFormCsrfToken();
$this->generateComponent("xui.box-1x1-begin");
$this->generateComponent("xui.panel-begin",array("title-text"=>$this->getFromLanguage($formTitle)));

?>
	<label class="xui-form-label" for="<?php $this->eElementId("connection"); ?>">
		<?php $this->eLanguage("select.connection"); ?>
	</label><br />
	<?php $this->generateView("form-select-connection"); ?>
	<br />
	<label class="xui-form-label" for="<?php $this->eElementId("layer"); ?>">
		<?php $this->eLanguage("backup_to"); ?>
	</label><br />
	<?php $this->generateView("form-select-layer"); ?>
	<br />
	<?php $this->generateViewLanguage("form-datasource-" . $layer); ?>

	<input type="hidden" name="action" value="default" />
	<input type="hidden" name="<?php $this->eElementName("id"); ?>" value="<?php echo $this->eElementValue("id", 0); ?>" />

<?php 

$this->eFormRequest();

$this->generateComponent("xui.panel-end");
$this->generateComponent("xui.box-1x1-end");

echo "</form>";

$this->generateView("form-return");
