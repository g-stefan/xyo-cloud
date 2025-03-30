<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$cssClass=$this->getArgument("css-class","");
$id=$this->getArgument("id","");
$noTopSpace=$this->getArgument("no-top-space",0);

if(strlen($cssClass)>0){
	$cssClass=" ".$cssClass;
};

if(strlen($id)>0){
	$id=" id=\"".$id."\"";
};

if(!$noTopSpace){
	echo "<div class=\"xui-box --space\"></div>";
};

?>
<div class="xui-panel<?php echo $cssClass; ?>"<?php echo $id; ?>>
	<div class="xui-panel_title">
