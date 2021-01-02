<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$path=$this->getModulePath($this->viewValue);
if($path) {
	if(file_exists($path."sys/info.json")) {
		$json=json_decode(file_get_contents($path."sys/info.json"));
		if($json) {

			$moduleName="";
			$moduleURI="";
			$authorName="";
			$authorURI="";
			$version="";
			$description="";
			$license="";

			if(property_exists($json,"theme")) {
				if(property_exists($json->theme,"name")) {
					$moduleName=$json->theme->name;
				};
				if(property_exists($json->theme,"uri")) {
					$moduleURI=$json->theme->uri;
				};
			};

			if(property_exists($json,"module")) {
				if(property_exists($json->module,"module")) {
					$moduleName=$json->module->name;
				};
				if(property_exists($json->module,"uri")) {
					$moduleURI=$json->module->uri;
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

			if(!strlen($moduleName)) {
				$moduleName=$this->viewValue;
			};
			
			echo "<a class=\"xui link\" href=\"".$this->requestUriThis(array("action"=>"form-edit","primary_key_value"=>$this->viewPrimaryKey))."\" onclick=\"".$this->instanceV."cmdDialogEdit('".$this->viewPrimaryKey."');return false;\">".$moduleName."</a>";

			if(strlen($description)) {
				echo "<br />";
				echo "<span class=\"xui -fg-aluminium-5\" style=\"font-size:14px;\">";
				echo $description;
				echo "</span>";
			};
			if(strlen($version)||
			   strlen($authorName)||
			   strlen($authorURI)||
			   strlen($license)){
				echo "<br />";
				echo "<span class=\"xui -fg-aluminium-4\" style=\"font-size:14px;\">";
				$separator="";
				if(strlen($version)) {
					echo $this->getFromLanguage("info.version")." ".$version;
					$separator=" <span class=\"xui -fg-aluminium-2\">|</span> ";
				};
				if(strlen($authorName)) {
					echo $separator;
					echo $this->getFromLanguage("info.author")." ";
					if(strlen($authorURI)) {
						echo "<a class=\"xui link\" href=\"".$authorURI."\" target=\"_blank\">".$authorName."</a>";
					}else {
						echo $authorName;
					};
					$separator=" <span class=\"xui -fg-aluminium-2\">|</span> ";
				};
				if(strlen($moduleURI)) {
					echo $separator;
					echo "<a class=\"xui link\" href=\"".$moduleURI."\" target=\"_blank\">".$this->getFromLanguage("info.site")."</a>";
					$separator=" <span class=\"xui -fg-aluminium-2\">|</span> ";
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

if($this->viewData[$this->viewId]["@write"]) {
	echo "<a class=\"xui link\" href=\"".$this->requestUriThis(array("action"=>"form-edit","primary_key_value"=>$this->viewPrimaryKey))."\" onclick=\"".$this->instanceV."cmdDialogEdit('".$this->viewPrimaryKey."');return false;\">".$this->viewValue."</a>";
}else{
	echo $this->viewValue;
};

