<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if (count($this->toolbar)) {

	foreach ($this->toolbar as $item) {
	
		if($item["type"]=="item"){
			echo "<a class=\"xui button -transparent -icon-left -".$item["mode"]." -effect-ripple ".$this->type."\" href=\"".$item["module"]."\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;	
		};

		if($item["type"]=="item-target"){
			echo "<a class=\"xui button -transparent -icon-left -".$item["mode"]." -effect-ripple ".$this->type."\" href=\"".$item["module"]."\" target=\"".$item["parameters"]."\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;	
		};

		if($item["type"]=="item-js"){
			echo "<a class=\"xui button -transparent -icon-left -".$item["mode"]." -effect-ripple ".$this->type."\" href=\"#\" onclick=\"".$item["parameters"].";return false;\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;
		};

		if($item["type"]=="item.important"){
			echo "<a class=\"xui button -transparent -icon-left -".$item["mode"]." -important -effect-ripple ".$this->type."\" href=\"".$item["module"]."\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;	
		};

		if($item["type"]=="item-js.important"){
			echo "<a class=\"xui button -transparent -icon-left -".$item["mode"]." -important -effect-ripple ".$this->type."\" href=\"#\" onclick=\"".$item["parameters"].";return false;\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;
		};

		if($item["type"]=="separator"){
			echo "<div class=\"xui _separator\"></div>";
			continue;	
		};

		if($item["type"]=="application-menu") {
			echo "<div class=\"xui button -transparent -icon -size-x32 -".$item["mode"]." -important -effect-ripple ".$this->type."\" id=\"popup-menu-application-action\">";
				echo $item["img"];
			echo "</div>";
			continue;
		};

	};

};
