<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ecssBegin();
echo ".xyo-app-template.-x-1{font-size:14px;}";
$this->ecssEnd();

$path=$this->getModulePath($this->viewValue);
if($path) {
	if(file_exists($path."sys/info.json")) {
		$json=json_decode(file_get_contents($path."sys/info.json"));
		if($json) {

			$themeName="";
			$themeURI="";
			$authorName="";
			$authorURI="";
			$version="";
			$description="";
			$license="";

			if(property_exists($json,"theme")) {
				if(property_exists($json->theme,"name")) {
					$themeName=$json->theme->name;
				};
				if(property_exists($json->theme,"uri")) {
					$themeURI=$json->theme->uri;
				};
			};

			if(property_exists($json,"author")) {
				if(property_exists($json->author,"name")) {
					$authorName=$json->author->name;
				};
				if(property_exists($json->author,"uri")) {
					$authorURI=$json->author->uri;
				};
			};

			if(property_exists($json,"version")) {
				$version=$json->version;
			};

			if(property_exists($json,"description")) {
				$description=$json->description;
			};

			if(property_exists($json,"license")) {
				$license=$json->license;
			};

			if(!strlen($themeName)) {
				$themeName=$this->viewValue;
			};

			echo $themeName;

			if(strlen($description)) {
				echo "<br />";
				echo "<span class=\"text-xui-rock-5-500 xyo-app-template -x-1\">";
				echo $description;
				echo "</span>";
			};
			if(strlen($version)||
			   strlen($authorName)||
			   strlen($authorURI)||
			   strlen($license)){
				echo "<br />";
				echo "<span class=\"text-xui-rock-4-500 xyo-app-template -x-1\">";
				$separator="";
				if(strlen($version)) {
					echo $this->getFromLanguage("info.version")." ".$version;
					$separator=" <span class=\"text-xui-rock-2-500\">|</span> ";
				};
				if(strlen($authorName)) {
					echo $separator;
					echo $this->getFromLanguage("info.author")." ";
					if(strlen($authorURI)) {
						echo "<a class=\"xui-link\" href=\"".$authorURI."\" target=\"_blank\">".$authorName."</a>";
					}else {
						echo $authorName;
					};
					$separator=" <span class=\"text-xui-rock-2-500\">|</span> ";
				};
				if(strlen($themeURI)) {
					echo $separator;
					echo "<a class=\"xui-link\" href=\"".$themeURI."\" target=\"_blank\">".$this->getFromLanguage("info.site")."</a>";
					$separator=" <span class=\"text-xui-rock-2-500\">|</span> ";
				};
				if(strlen($license)) {
					echo $separator;
					echo $this->getFromLanguage("info.license")." ".$license;
				};
				echo "</span>";
			};			
			return;
		};
	};
};

echo $this->viewValue;
