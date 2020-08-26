<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$cssClass=$this->getArgument("css-class","");
$id=$this->getArgument("id","");

if(strlen($cssClass)>0){
	$cssClass=" ".$cssClass;
};

if(strlen($id)>0){
	$id=" id=\"".$id."\"";
};

?>
<div class="xui box -space"></div>
<div class="xui panel<?php echo $cssClass; ?>"<?php echo $id; ?>>
	<div class="xui _title">
