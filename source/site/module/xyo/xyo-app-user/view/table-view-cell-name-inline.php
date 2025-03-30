<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ecssBegin();
echo ".xyo-app-user.--x-1{width:64px;padding-right:3px;}";
echo ".xyo-app-user.--x-2{width:64px;height:64px;overflow:hidden;border-radius:50%;cursor:pointer;border-style:solid;border-width:1px;}";
echo ".xyo-app-user.--x-3{padding-left:3px;}";
echo ".xyo-app-user.--x-4{font-size:14px;}";
echo ".xyo-app-user.--x-5{color:#44CC44;font-size:16px;line-height:16px;margin-top:2px;display:inline-block;float:left;}";
echo ".xyo-app-user.--x-6{font-size:16px;line-height:16px;margin-top:2px;display:inline-block;float:left;}";
$this->ecssEnd();


echo "<table class=\"xui\"><tr>";

echo "<td class=\"xyo-app-user --x-1\">";
	$uid=$this->getUID();
	echo "<div id=\"".$uid."\" class=\"border-xui-rock-1-500 xyo-app-user --x-2\">";
		$modThumbnail=&$this->getModule("xyo-mod-thumbnail");
		$xuiImage=&$this->getModule("xui-form-image");
		$this->ecssBegin();
		echo ".".$this->name."-image_".$this->viewRow["id"]." {";
			$pictureOk=false;
			if(strlen($this->viewRow["picture"])) {
				$userImageThumbnail = $modThumbnail->xuiMakeThumbnailSite($this->viewRow["picture"],64,64);
				if(strlen($userImageThumbnail)>0) {
					echo "display:block;";
					echo "width:64px;";
					echo "height:64px;";
					echo "background-image:url(\"".$userImageThumbnail."\");";
					$pictureOk=true;
				};
			};
			if(!$pictureOk){
				$xuiImage->eImageCss("\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHZpZXdCb3g9IjAgMCA2NDAgNDgwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsLTU3MCkiPiA8ZyB0cmFuc2Zvcm09Im1hdHJpeCgxLjA0OTIwOSwwLDAsMS4wNDkyMDksLTUuMDc1MzI5NSwtNDUuNzU1MTQpIj4gIDxjaXJjbGUgICAgcj0iNzMuMjE0Mjc5IiAgICBjeT0iNzEyLjcxOTMiICAgIGN4PSIzMTIuNTAwMDMiICAgIGlkPSJwYXRoNDE0NyIgICAgc3R5bGU9ImZpbGw6I0QzRDdDRjtmaWxsLW9wYWNpdHk6MSIgLz4gICAgICA8cGF0aCAgICAgICAgIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsNTcyLjM2MjE2KSIgICAgICAgICBkPSJtIDMxMy45Mjc3MywyMzEuNDI3NzMgYSAxMzguMjE0MjgsMTgwLjM1NzEzIDAgMCAwIC0xMzguMjEyODksMTgwLjM1NzQzIDEzOC4yMTQyOCwxODAuMzU3MTMgMCAwIDAgOC40ODQzOCw2MS43ODcxMSBsIDI1OS4zOTY0OCwwIGEgMTM4LjIxNDI4LDE4MC4zNTcxMyAwIDAgMCA4LjU0Njg4LC02MS43ODcxMSAxMzguMjE0MjgsMTgwLjM1NzEzIDAgMCAwIC0xMzguMjE0ODUsLTE4MC4zNTc0MyB6IiAgICAgICAgIHN0eWxlPSJmaWxsOiNEM0Q3Q0Y7ZmlsbC1vcGFjaXR5OjEiICAgICAgICAgLz4gICA8L2c+ICA8L2c+PC9zdmc+\"".
				",-16,0,1.5,64,64,64,64");
			};
		echo "}";            
		$this->ecssEnd();
		echo "<div class=\"".$this->name."-image_".$this->viewRow["id"]."\"></div>";
	echo "</div>";
	$this->ejsBegin();
	echo "document.getElementById(\"".$uid."\").onclick=function(){".$this->getCmdEditOnClick($this->viewKey,$this->viewId)."};";
	$this->ejsEnd();
echo "</td>";

// ---
                                                                                         
echo "<td class=\"xyo-app-user --x-3\">";
	$uid=$this->getUID();
	echo "<a id=\"".$uid."\" class=\"xui-link\" href=\"".$this->getCmdEditLink($this->viewId)."\">";
		echo "<span>";
		echo $this->viewRow["name"];
		echo "</span>";
	echo "</a>";
	$this->ejsBegin();
	echo "document.getElementById(\"".$uid."\").onclick=function(){".$this->getCmdEditOnClick($this->viewKey,$this->viewId)."};";
	$this->ejsEnd();
	echo "<br>";
	echo "<span class=\"text-xui-rock-5-500 xyo-app-user --x-4\">";
		if(strlen($this->viewRow["description"])==0){
			echo "User";
		} else {
			echo $this->viewRow["description"];
		};
	echo "</span>";
	echo "<br>";
	echo "<span class=\"text-xui-rock-4-500 xyo-app-user --x-4\">";
	if($this->viewRow["logged_in"]) {
		echo "<span class=\"lucide-user-check xyo-app-user --x-5\"></span>";
	} else {
		echo "<span class=\"lucide-user-x xyo-app-user --x-6\"></span>";
	};
	echo "&nbsp;&nbsp;";
	echo $this->viewRow["logged_at"];
	echo "</span>";
echo "</td>";

echo "</tr></table>";
