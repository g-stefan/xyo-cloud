<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$title=$this->getArgument("title",$this->getParameter("form_title"));
$cssClass=$this->getArgument("css-class","");

if(strlen($cssClass)>0){
	$cssClass=" ".$cssClass;
};

?>
	</div>
	<div class="xui-inner-box --x1x2<?php echo $cssClass; ?>">
