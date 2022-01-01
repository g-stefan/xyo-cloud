<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$item=$this->getArgument("item",array());

$isPopup=false;
if(array_key_exists("popup",$item)){
	if(count($item["popup"])){
		$isPopup=true;
	};
};

$active=false;
if(array_key_exists("active",$item)){
	$active=$item["active"];
};

$url=" href=\"#\" onclick=\"return false;\"";
if(array_key_exists("url",$item)){
	$url=" href=\"".$item["url"]."\"";
	if($isPopup){
		$url.=" onclick=\"return false;\"";
	};
};
if(array_key_exists("js",$item)){
	$url=" href=\"#\" onclick=\"".$item["js"].";return false;\"";
	if($isPopup){
		$url.=" onclick=\"return false;\"";
	};
};

$icon="";
if(array_key_exists("icon",$item)){
	$icon=$item["icon"];
};

$text="";
if(array_key_exists("text",$item)){
	$text=$item["text"];
};

if($item["type"]=="separator"){
	echo "<li class=\"xui _separator\"></li>";
	return;
};

if($item["type"]=="space"){
	echo "<li class=\"xui _space\"></li>";
	return;
};

if($item["type"]=="label"){
	echo "<li class=\"xui _label\">".$text."</li>";
	return;
};

if($isPopup){
	echo "<li class=\"xui _submenu".($active?" -on":"")."\">";
}else{
	echo "<li>";
};

echo "<a class=\"xui action -effect-ripple".($active?" -selected":"").($isPopup?" -toggle":"")."\"".$url.($isPopup?" data-xui-toggle=\"parent\"":"").">";
	echo $icon;
	echo "<span>".$text."</span>";
	if($isPopup){
		echo "<i class=\"material-icons\">chevron_right</i>";
	};
echo "</a>";

if($isPopup){
	echo "<ul>";
		$this->generateNavigationDrawerMenuView($item["popup"]);
	echo "</ul>";
};

echo "</li>";

