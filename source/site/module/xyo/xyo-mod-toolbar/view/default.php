<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if (count($this->toolbar)) {

	foreach ($this->toolbar as $item) {
	
		if($item["type"]=="item"){
			echo "<a class=\"xui-button --transparent --icon-left --".$item["mode"]." xui-effect-ripple ".$this->type." --toolbar\" href=\"".$item["module"]."\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;	
		};

		if($item["type"]=="item-target"){
			echo "<a class=\"xui-button --transparent --icon-left --".$item["mode"]." xui-effect-ripple ".$this->type." --toolbar\" href=\"".$item["module"]."\" target=\"".$item["parameters"]."\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;	
		};

		if($item["type"]=="item-js"){
			$uid=$this->getUID();
			echo "<a id=\"".$uid."\" class=\"xui-button --transparent --icon-left --".$item["mode"]." xui-effect-ripple ".$this->type." --toolbar\" href=\"#\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			$this->ejsBegin();
			echo "document.getElementById(\"".$uid."\").onclick=function(){".$item["parameters"].";return false;};";
			$this->ejsEnd();
			continue;
		};

		if($item["type"]=="item.important"){
			echo "<a class=\"xui-button --transparent --icon-left --".$item["mode"]." --important xui-effect-ripple ".$this->type." --toolbar\" href=\"".$item["module"]."\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			continue;	
		};

		if($item["type"]=="item-js.important"){
			$uid=$this->getUID();
			echo "<a id=\"".$uid."\" class=\"xui-button --transparent --icon-left --".$item["mode"]." --important xui-effect-ripple ".$this->type." --toolbar\" href=\"#\">";
				echo $item["img"];
				echo "<span>";
				echo $item["title"];
				echo "</span>";
			echo "</a>";
			$this->ejsBegin();
			echo "document.getElementById(\"".$uid."\").onclick=function(){".$item["parameters"].";return false;};";
			$this->ejsEnd();
			continue;
		};

		if($item["type"]=="separator"){
			echo "<div class=\"xui-application-toolbar_separator\"></div>";
			continue;	
		};

		if($item["type"]=="application-menu") {
			echo "<div class=\"xui-button --transparent --icon --size-x32 --".$item["mode"]." --important xui-effect-ripple ".$this->type." --toolbar\" id=\"xui-popup-menu-application_action\">";
				echo $item["img"];
			echo "</div>";
			continue;
		};

	};

};
