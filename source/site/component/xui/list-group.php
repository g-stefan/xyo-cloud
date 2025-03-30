<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$items = $this->getArgument("items",array());

echo "<ul class=\"xui-list-group\">";
foreach ($items as $key => $value) {

	$id="";
	$text="";
	$selected=false;
	$iconRight="";

	if(array_key_exists("id",$value)){
		$id=$value["id"];
	};
	if(array_key_exists("text",$value)){
		$text=$value["text"];
	};
	if(array_key_exists("selected",$value)){
		$selected=$value["selected"];
	};
	if(array_key_exists("icon-right",$value)){
		$iconRight=$value["icon-right"];
	};
	
	if($selected){
		echo "<li class=\"--active\">";
	}else{
		echo "<li>";
	};

	if(strlen($id)){
		echo "<div>".$id."</div>";
	};

	echo "<span>".$text."</span>";

	if(strlen($iconRight)){
		echo $iconRight;
	};

	echo "</li>";

};
echo "</ul>";
