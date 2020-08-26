<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");
$onSubmit=$this->getArgument("onsubmit","");
if(strlen($onSubmit)){
	$onSubmit=" onsubmit=\"".$onSubmit."\"";
};

$action=$this->getArgument("action",$this->getFormAction());

?>
<form name="<?php $this->eFormName(); ?>" id="<?php $this->eFormName(); ?>" method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data" class="xui application-form" <?php echo $onSubmit; ?>>
