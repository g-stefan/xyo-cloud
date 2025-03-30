<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
$uid=$this->getFormName();

$onSubmit=$this->getArgument("onsubmit","");
if(strlen($onSubmit)){
	$this->setHtmlJsSourceOrAjax("document.getElementById(\"".$uid."\").onsubmit=function(){".$onSubmit."};");	
};

$action=$this->getArgument("action",$this->getFormAction());
$attributeList=$this->getArgument("attributes",array());
$attributes="";
foreach($attributeList as $key=>$value){
	$attributes.=" ".$key."=\"".$value."\"";
};

?>
<form name="<?php $this->eFormName(); ?>" id="<?php echo $uid; ?>" method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data" class="xui-application-main_form" <?php echo $attributes; echo $onSubmit; ?>>
<?php $this->eFormCsrfToken();