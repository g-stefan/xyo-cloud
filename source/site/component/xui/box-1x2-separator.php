<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$title=$this->getArgument("title",$this->getParameter("form_title"));
$cssClass=$this->getArgument("css-class","");

if(strlen($cssClass)>0){
	$cssClass=" ".$cssClass;
};

?>
	</div>
	<div class="xui box -x1x2<?php echo $cssClass; ?>">
