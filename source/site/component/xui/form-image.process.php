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
$delete = $this->getArgument("delete",false);
$deleteThumbnails = $this->getArgument("delete_thumbnails",true);
$makeThumbnails = $this->getArgument("make_thumbnails",array());
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
							if($deleteThumbnails) {
								$modThumbnail=&$this->getModule("xyo-mod-thumbnail");
								$modThumbnail->xuiRemoveThumbnails($fileDelete);
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
if($delete){
	$elementDelete = 1;
	$value = $this->getElementValue($element,"");
	if(strlen($value)>0){
		$list=str_getcsv($value,",","\"","\\");
		$this->setElementValue($element."_file",$list[0]);
	};	
};
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
			if($deleteThumbnails) {
				$modThumbnail=&$this->getModule("xyo-mod-thumbnail");
				$modThumbnail->xuiRemoveThumbnails($fileDelete);
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
	$list=str_getcsv($value,",","\"","\\");
	$fileName=$list[0];
};

$this->setElementValue($element."_offset_x",number_format(1*$this->getElementValue($element."_offset_x",0),0,".",""));
$this->setElementValue($element."_offset_y",number_format(1*$this->getElementValue($element."_offset_y",0),0,".",""));
$this->setElementValue($element."_zoom",number_format($this->getElementValue($element."_zoom",1),4,".",""));
$this->setElementValue($element."_width",number_format(1*$this->getElementValue($element."_width",320),0,".",""));
$this->setElementValue($element."_height",number_format(1*$this->getElementValue($element."_height",240),0,".",""));
$this->setElementValue($element."_view_x",number_format(1*$this->getElementValue($element."_view_x",320),0,".",""));
$this->setElementValue($element."_view_y",number_format(1*$this->getElementValue($element."_view_y",240),0,".",""));

if(!$isDeleted){
	if(!(is_null($fileName) || (strlen($fileName)==0))){
		$value="\"".$fileName."\",";
		$value.=$this->getElementValue($element."_offset_x").",";
		$value.=$this->getElementValue($element."_offset_y").",";
		$value.=$this->getElementValue($element."_zoom").",";
		$value.=$this->getElementValue($element."_width").",";
		$value.=$this->getElementValue($element."_height").",";
		$value.=$this->getElementValue($element."_view_x").",";
		$value.=$this->getElementValue($element."_view_y").",";
		$value.=md5($value);
		$this->setElementValue($element,$value);
	}else{
		$this->setElementValue($element,"");
	};
};

if(count($makeThumbnails)) {
	$image=$this->getElementValue($element,"");
	if(strlen($image)) {
		$modThumbnail=&$this->getModule("xyo-mod-thumbnail");
		foreach($makeThumbnails as $value) {
			$modThumbnail->xuiMakeThumbnail($image,$value[0],$value[1]);
		};
	};
};

