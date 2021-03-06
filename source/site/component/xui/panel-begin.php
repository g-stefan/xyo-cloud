<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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

if(strlen($title)==0){
	$noTitle=1;
};

if(strlen($cssClass)>0){
	$cssClass=" ".$cssClass;
};

if(strlen($id)>0){
	$id=" id=\"".$id."\"";
};

?>
<div class="xui box -space"></div>
<div class="xui panel<?php echo $cssClass; ?>"<?php echo $id; ?>>
<?php if(!$noTitle) {?>
	<div class="xui _title"><?php echo $title; ?></div>
	<div class="xui _line"></div>
<?php }; ?>
	<div class="xui _content">
