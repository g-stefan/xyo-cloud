<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$formTitle=$this->getParameter("form_title");
$title=$this->getArgument("title","");
if($title=="form_title"){
	$title=$formTitle;
};
if(strlen($title)>0){
	$title=$this->getFromLanguage($title);
};
$title=$this->getArgument("title-text",$title);
$noTitle=$this->getArgument("no-title",0);
$cssClass=$this->getArgument("css-class","");
$id=$this->getArgument("id","");
$noTopSpace=$this->getArgument("no-top-space",0);

if(strlen($title)==0){
	$noTitle=1;
};

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
<?php if(!$noTitle) {?>
	<div class="xui-panel_title"><?php echo $title; ?></div>
	<div class="xui-panel_line"></div>
<?php }; ?>
	<div class="xui-panel_content">
