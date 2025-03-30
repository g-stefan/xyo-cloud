<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_Thumbnail";

class xyo_mod_Thumbnail extends xyo_Module {

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
	}

	public function makeThumbnail($basePath,$imageName,$width,$height,$force=false) {
		$fileExtension=$this->getFileExtension($imageName);
		if($fileExtension){}else{return "";};	
		if(!$width){$width="";};
		if(!$height){$height="";};

		$wwwFile=strtolower("thumbnails/".basename($imageName,".".$fileExtension)."_".$width."x".$height.".".$fileExtension);
		$thumbFile=$basePath.$wwwFile;
		if(!$force){
			if(file_exists($thumbFile)){
				$t1=filemtime($imageName);
				$t2=filemtime($thumbFile);
				if($t2>=$t1){
					return $thumbFile;
				};
			};
		};

		if(!($fileExtension==="png"||
		   $fileExtension==="jpg"||
		   $fileExtension==="jpeg"
		)){return "";};

		$thumbDir=$basePath."thumbnails";
		if(is_dir($thumbDir)){}else{
			@mkdir($thumbDir);
			if(!is_dir($thumbDir)){return "";};
		};

		$srcImg="";
		if(!$width){
			if(!$height){
				return "";
			};
		};

		if($fileExtension==="png"){
			$srcImg=imagecreatefrompng($imageName);
		}else{
			$srcImg=imagecreatefromjpeg($imageName);
		};
		if(!$srcImg){return "";};
	
		$newW=$width;
		$newH=$height;
		$oldW=imagesx($srcImg);
		$oldH=imagesy($srcImg);

		if($newW){
			$wFit=$oldW/$newW;
		}else{
			$hFit=$oldH/$newH;
			$wFit=$hFit;
			$newW=$oldW/$wFit;
		};

		if($newH){
			$hFit=$oldH/$newH;
		}else{
			$wFit=$oldW/$newW;
			$hFit=$wFit;
			$newH=$oldH/$hFit;
		};

		$factor=max($wFit,$hFit);

		$sizeW=floor($newW*$factor);
		$sizeH=floor($newH*$factor);

		$newW=floor($oldW/$factor);
		$newH=floor($oldH/$factor);

		$tW=floor(($width-$newW)/2);
		$tH=floor(($height-$newH)/2);

		$dstImg=imagecreatetruecolor($width,$height);
		imagealphablending($dstImg,false);
		if($fileExtension==="png"){
			$color1=imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
		}else{
			$color1=imagecolorallocate($dstImg, 255, 255, 255);
		};	
		imagefilledrectangle($dstImg,0,0,$width,$height,$color1);
		imagecopyresampled($dstImg,$srcImg,$tW,$tH,0,0,$newW,$newH,$oldW,$oldH);
		imagesavealpha($dstImg,true);

		if($fileExtension==="png"){
			imagepng($dstImg,$thumbFile);
		}else{		
			imagejpeg($dstImg,$thumbFile,90);
		};

		imagedestroy($dstImg); 
		imagedestroy($srcImg);

		return $thumbFile;
	}

	public function getFileExtension($name){
		$lastdot = strrpos($name, '.');
		if (!($lastdot === FALSE)) {
			return substr($name, $lastdot + 1);
		};
		return "";
	}

	public function removeThumbnails($basePath,$imageName) {
		$fileExtension=$this->getFileExtension($imageName);
		if($fileExtension){}else{return;};	
		$wwwFileBase=strtolower(basename($imageName,".".$fileExtension));
		
		$thumbList = array();
		if ($dh = @opendir($basePath."thumbnails/")) {			
			while (false !== ($obj = readdir($dh))) {
				if ($obj == '.' || $obj == '..') {
					continue;
				};
				if(strncmp($obj, $wwwFileBase,strlen($wwwFileBase))==0) {
					array_push($thumbList, $basePath."thumbnails/" . $obj);
				};
			};
			closedir($dh);
		};

		foreach($thumbList as $file) {
			@unlink($file);			
		};
	}

	public function xuiMakeThumbnail($image,$width,$height,$force=false) {
		$modXUIImage=&$this->getModule("xui-form-image");
		$imageInfo=$modXUIImage->getImageInfo($image);
		if(count($imageInfo)==0){
			return "";
		};
		
		$basePath=dirname($imageInfo["fileName"])."/";
		$imageName=$imageInfo["fileName"];
		$fileExtension=$this->getFileExtension($imageName);
		if($fileExtension){}else{return "";};	
		if(!$width){$width="";};
		if(!$height){$height="";};

		$wwwFile=strtolower("thumbnails/".basename($imageName,".".$fileExtension)."_".$imageInfo["hash"]."_".$width."x".$height.".".$fileExtension);
		$thumbFile=$basePath.$wwwFile;
		if(!$force){
			if(file_exists($thumbFile)){
				$t1=filemtime($imageName);
				$t2=filemtime($thumbFile);
				if($t2>=$t1){
					return $thumbFile;
				};
			};
		};

		if(!($fileExtension==="png"||
		   $fileExtension==="jpg"||
		   $fileExtension==="jpeg"
		)){return "";};

		$thumbDir=$basePath."thumbnails";
		if(is_dir($thumbDir)){}else{
			@mkdir($thumbDir);
			if(!is_dir($thumbDir)){return "";};
		};

		$srcImg="";
		if(!$width){
			if(!$height){
				return "";
			};
		};
		
		if($fileExtension==="png") {
			$srcImg=imagecreatefrompng($imageName);
		} else {
			$srcImg=imagecreatefromjpeg($imageName);
		};
		if(!$srcImg){return "";};

		$dstImg=imagecreatetruecolor($width,$height);
		imagealphablending($dstImg,false);
		if($fileExtension==="png") {
			$color1=imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
		} else {
			$color1=imagecolorallocate($dstImg, 255, 255, 255);
		};
		imagefilledrectangle($dstImg,0,0,$width,$height,$color1);

		$srcX = -($imageInfo["offsetX"] * (1/$imageInfo["zoom"]));
		$srcY = -($imageInfo["offsetY"] * (1/$imageInfo["zoom"]));
		$srcW = $imageInfo["viewX"] * (1/$imageInfo["zoom"]);
		$srcH = $imageInfo["viewY"] * (1/$imageInfo["zoom"]);

		imagecopyresampled($dstImg,$srcImg,0,0,$srcX,$srcY,$width,$height,$srcW,$srcH);
		imagesavealpha($dstImg,true);

		if($fileExtension==="png") {
			imagepng($dstImg,$thumbFile);
		} else {
			imagejpeg($dstImg,$thumbFile,90);
		};

		imagedestroy($dstImg); 
		imagedestroy($srcImg);

		return $thumbFile;
	}

	public function xuiRemoveThumbnails($image) {
		$modXUIImage=&$this->getModule("xui-form-image");
		$imageInfo=$modXUIImage->getImageInfo($image);
		if(count($imageInfo)==0) {
			return;
		};
	
		$basePath=dirname($imageInfo["fileName"])."/";
		$imageName=basename($imageInfo["fileName"]);

		$fileExtension=$this->getFileExtension($imageName);
		if($fileExtension){}else{return;};	
		$fileBase=strtolower(basename($imageName,".".$fileExtension));
		
		$thumbList = array();
		if ($dh = @opendir($basePath."thumbnails/")) {
			while (false !== ($obj = readdir($dh))) {
				if ($obj == '.' || $obj == '..') {
					continue;
				};
				if(strncmp($obj, $fileBase,strlen($fileBase))==0) {
					array_push($thumbList, $basePath."thumbnails/" . $obj);
				};
			};
			closedir($dh);
		};

		foreach($thumbList as $file) {
			@unlink($file);
		};
	}

	public function xuiMakeThumbnailSite($image,$width,$height,$force=false) {
		$imageSite = $this->xuiMakeThumbnail($image,$width,$height,$force);
		if(strlen($imageSite)==0){
			return $imageSite;
		};
		return $this->site.$imageSite;
	}

}
