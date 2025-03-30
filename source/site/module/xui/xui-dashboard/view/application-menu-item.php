<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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

$onclick="return false;";
$url=" href=\"#\"";
if(array_key_exists("url",$item)){
	$url=" href=\"".$item["url"]."\"";
	$onclick="";
	if($isPopup){		
		$onclick="return false;";
	};
};
if(array_key_exists("js",$item)){
	$onclick=$item["js"].";return false;";	
	if($isPopup){		
		$onclick="return false;";	
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
	echo "<li class=\"xui-menu_separator\"></li>";
	return;
};

if($item["type"]=="space"){
	echo "<li class=\"xui-menu_space\"></li>";
	return;
};

if($item["type"]=="label"){
	echo "<li class=\"xui-menu_label\">".$text."</li>";
	return;
};

if($isPopup){
	echo "<li class=\"xui-menu_submenu\">";
}else{
	echo "<li>";
};

$uid=$this->getUID();
echo "<a id=\"$uid\" class=\"xui-menu_item xui-effect-ripple".($active?" --selected":"").($isPopup?" xui-toggle":"")."\"".$url.($isPopup?" data-xui-toggle=\"parent\"":"").">";
	echo $icon;
	echo "<span>".$text."</span>";
	if($isPopup){
		echo "<i class=\"lucide-chevron-right\"></i>";
	};
echo "</a>";
if(strlen($onclick)>0){
	$this->ejsBegin();
	echo "document.getElementById(\"".$uid."\").onclick=function(){".$onclick."};";
	$this->ejsEnd();
};

if($isPopup){
	echo "<ul>";
		$this->generateApplicationMenuView($item["popup"]);
	echo "</ul>";
};

echo "</li>";
