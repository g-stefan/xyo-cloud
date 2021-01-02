<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$fileName = $this->getArgument("filename","");
$deleteBeforeSave = $this->getArgument("delete_before_save",false);
$elementName = $this->getElementName($element);
if(strlen($fileName)){
	if($deleteBeforeSave){
		$fileDelete=$this->getElementValue($element."_file","");
		if(strlen($fileDelete)){
			if(file_exists($fileDelete)){
				@unlink($fileDelete);
			};
		};
	};
	$this->setElementValue($element,$fileName);
	file_put_contents($fileName,$this->getElementValue($element."_html"));
};

