<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$format = $this->getElementValueString($element."_format","");
if(strlen($format)){
	$format=base64_decode($format);
};
$format = $this->getArgument("format",strlen($format)?$format:$this->cloud->get("locale_date_format",""));
if(strlen($format)){
	if(($format=="H:i:s")||($format=="hh:ii")){
		$value=$this->getElementValueString($element);
		if(strlen($value)){
			$this->setElementValue($element,substr($value,0,2).":".substr($value,3,2));
		};
	};
}else{
	$value=$this->getElementValueString($element);
	if(strlen($value)){
		$this->setElementValue($element,substr($value,0,2).":".substr($value,3,2));
	};
};

$value=$this->getElementValue($element);
if(strlen($value)==0){
	$this->setElementValue($element,null);	
};
