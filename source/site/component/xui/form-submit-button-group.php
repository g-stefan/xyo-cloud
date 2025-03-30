<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$group = $this->getArgument("group");
if(count($group)>0){

	echo "<div class=\"xui-button-group\">";

	foreach($group as $key=>$value){
		if($value=="disabled"){
			echo "<input type=\"submit\" class=\"xui-button --disabled\" name=\"".$this->getElementName($key)."\" value=\"".$this->getFromLanguage("button.".$key)."\" disabled=\"disabled\"></input>";
			continue;
		};	
		echo "<input type=\"submit\" class=\"xui-button --".$value."\" name=\"".$this->getElementName($key)."\" value=\"".$this->getFromLanguage("button.".$key)."\"></input>";
	}

	echo "</div>";

};
