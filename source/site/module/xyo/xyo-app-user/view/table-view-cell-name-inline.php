<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

echo "<table class=\"xui\"><tr>";

echo "<td class=\"xui\" style=\"width:64px;padding-right:3px;\">";
	echo "<div class=\"xui -bd-rock-1\" style=\"width:64px;height:64px;overflow:hidden;border-radius:50%;cursor:pointer;border-style:solid;border-width:1px;\"".
		" onclick=\"".$this->getCmdEditOnClick($this->viewKey,$this->viewId)."\">";
		$xuiImage=&$this->getModule("xui-form-image");
		echo "<style>";
		echo ".".$this->name."-image_".$this->viewRow["id"]." {";
			if(strlen($this->viewRow["picture"])) {
				$xuiImage->eImageCss($this->viewRow["picture"]);
			}else{
				$xuiImage->eImageCss("\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHZpZXdCb3g9IjAgMCA2NDAgNDgwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsLTU3MCkiPiA8ZyB0cmFuc2Zvcm09Im1hdHJpeCgxLjA0OTIwOSwwLDAsMS4wNDkyMDksLTUuMDc1MzI5NSwtNDUuNzU1MTQpIj4gIDxjaXJjbGUgICAgcj0iNzMuMjE0Mjc5IiAgICBjeT0iNzEyLjcxOTMiICAgIGN4PSIzMTIuNTAwMDMiICAgIGlkPSJwYXRoNDE0NyIgICAgc3R5bGU9ImZpbGw6I0QzRDdDRjtmaWxsLW9wYWNpdHk6MSIgLz4gICAgICA8cGF0aCAgICAgICAgIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsNTcyLjM2MjE2KSIgICAgICAgICBkPSJtIDMxMy45Mjc3MywyMzEuNDI3NzMgYSAxMzguMjE0MjgsMTgwLjM1NzEzIDAgMCAwIC0xMzguMjEyODksMTgwLjM1NzQzIDEzOC4yMTQyOCwxODAuMzU3MTMgMCAwIDAgOC40ODQzOCw2MS43ODcxMSBsIDI1OS4zOTY0OCwwIGEgMTM4LjIxNDI4LDE4MC4zNTcxMyAwIDAgMCA4LjU0Njg4LC02MS43ODcxMSAxMzguMjE0MjgsMTgwLjM1NzEzIDAgMCAwIC0xMzguMjE0ODUsLTE4MC4zNTc0MyB6IiAgICAgICAgIHN0eWxlPSJmaWxsOiNEM0Q3Q0Y7ZmlsbC1vcGFjaXR5OjEiICAgICAgICAgLz4gICA8L2c+ICA8L2c+PC9zdmc+\"".
				",-16,0,1.5,64,64,64,64");
			};
		echo "}";            
		echo "</style>";
		echo "<div class=\"xui ".$this->name."-image_".$this->viewRow["id"]."\"></div>";
	echo "</div>";
echo "</td>";

// ---
                                                                                         
echo "<td class=\"xui\" style=\"padding-left:3px;\">";
	echo "<a class=\"xui link\" href=\"".$this->getCmdEditLink($this->viewId)."\" onclick=\"".$this->getCmdEditOnClick($this->viewKey,$this->viewId)."\">";
		echo "<span class=\"xui\">";
		echo $this->viewRow["name"];
		echo "</span>";
	echo "</a>";
	echo "<br />";
	echo "<span class=\"xui -fg-aluminium-5\" style=\"font-size:14px;\">";
		if(strlen($this->viewRow["description"])==0){
			echo "User";
		} else {
			echo $this->viewRow["description"];
		};
	echo "</span>";
	echo "<br />";
	echo "<span class=\"xui -fg-aluminium-4\" style=\"font-size:14px;\">";
	if($this->viewRow["logged_in"]) {
		echo "<span class=\"material-icons\" style=\"color:#44CC44;font-size:16px;line-height:16px;margin-top:2px;display:inline-block;float:left;\">work</span>";
	} else {
		echo "<span class=\"material-icons\" style=\"font-size:16px;line-height:16px;margin-top:2px;display:inline-block;float:left;\">work_off</span>";
	};
	echo "&nbsp;&nbsp;";
	echo $this->viewRow["logged_at"];
	echo "</span>";
echo "</td>";

echo "</tr></table>";
