<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");

$fileName = $this->getArgument("filename","");
$extension = $this->getArgument("extension",false);
$deleteBeforeSave = $this->getArgument("delete_before_save",false);
$elementName = $this->getElementName($element);
$isOk=false;
if(strlen($fileName)){
	if(array_key_exists($elementName,$_FILES)){
		if(1*$_FILES[$elementName]["error"]){
			if(strlen($_FILES[$elementName]["name"])){
				$this->setElementErrorFromLanguage($element, "file_upload");
			};
		}else{
			if($extension){
				$fileName.=".".strtolower(pathinfo($_FILES[$elementName]["name"], PATHINFO_EXTENSION));
			};
			if (move_uploaded_file($_FILES[$elementName]["tmp_name"], $fileName)) {
				if($deleteBeforeSave){
					$fileDelete=$this->getElementValue($element."_file","");
					if(strlen($fileDelete)){
						$readonly=$this->getArgument("readonly",array());
						$toDel=true;
						foreach($readonly as $key=>$value){
							if($value===$fileDelete){
								$toDel=false;
								break;
							};
						};
						if($fileName===$fileDelete){
							$toDel=false;
						};
						if($toDel){
							if(file_exists($fileDelete)){
								@unlink($fileDelete);
							};
						};
					};
				};
				$this->setElementValue($element."_delete",0);
				$isOk=true;
			} else {
				$this->setElementErrorFromLanguage($element, "file_upload_move");
			};
		};
	};
};

$isDeleted=false;
$elementDelete = $this->getElementValue($element."_delete");
if(strlen($elementDelete)){
	if(1*$elementDelete==1){
		$fileDelete=$this->getElementValue($element."_file","");
		$readonly=$this->getArgument("readonly",array());
		$toDel=true;
		foreach($readonly as $key=>$value){
			if($value===$fileDelete){
				$toDel=false;
				break;
			};
		};
		if($toDel){
			if(file_exists($fileDelete)){
				@unlink($fileDelete);
			};
		};
		$this->setElementValue($element,"");
		$isOk=true;
		$isDeleted=true;
	};
};

if(!$isOk){
	$value=$this->getElementValue($element."_value","");
	$this->setElementValue($element,$value);
};

if((!$isDeleted)&&($isOk)){
	$this->setElementValue($element,$fileName);
};

