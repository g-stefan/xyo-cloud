<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->generateView("notify-alert");
$this->generateView("notify-error");

// ---

if($this->isNew){
	$this->setParameter("form.title","form.title_new");
}else{
	$this->setParameter("form.title","form.title_edit");
};

?>
<?php $this->ejsBegin(); ?>
	function <?php echo $this->instanceV; ?>doCommand(action){
		document.forms.<?php $this->eFormName(); ?>.elements.<?php echo $this->instanceV; ?>action.value=action;
		document.forms.<?php $this->eFormName(); ?>.elements.csrf_token.value=window.csrfToken;
		document.forms.<?php $this->eFormName(); ?>.submit();
		return false;
	}
<?php $this->ejsEnd(); 

$this->generateComponent("xui.form-action-begin");
$this->generateView($this->getParameter("form.view","form"));
$this->generateComponent("xui.form-action-end",array(
	"parameters"=>array(
		$this->instanceV."action"=>"default",
		$this->getElementName("primary_key_value") => $this->getElementValue("primary_key_value", "")
	)
));
$this->generateView("form-call");
$this->generateComponent("xui.box-space");
$this->generateView("form-return");
