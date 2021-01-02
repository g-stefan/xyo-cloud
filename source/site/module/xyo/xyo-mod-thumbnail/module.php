<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_Thumbnail";

class xyo_mod_Thumbnail extends xyo_Module {

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
	}

	public function makeThumbnail($basePath,$imageName,$width,$height,$force=false){
		$fileExtension=$this->getFileExtension($imageName);
		if($fileExtension){}else{return null;};	
		if(!$width){$width=null;};
		if(!$height){$height=null;};
		$wwwFile=strtolower("thumbnails/".basename($imageName,".".$fileExtension)."_".$width."x".$height.".".$fileExtension);
		$thumbFile=$basePath.$wwwFile;
		if(!$force){
			if(file_exists($thumbFile)){
				$t1=filemtime($imageName);
				$t2=filemtime($thumbFile);
				if($t2>=$t1){
					return $wwwFile;
				};
			};
		};
		if(!($fileExtension==="png"||
		   $fileExtension==="jpg"||
		   $fileExtension==="jpeg"
		)){return null;};

		$thumbDir=$basePath."thumbnails";
		if(is_dir($thumbDir)){}else{
			@mkdir($thumbDir);
			if(!is_dir($thumbDir)){return null;};
		};
		$srcImg=null;
		if(!$width){
			if(!$height){
				return null;
			};
		};
		if($fileExtension==="png"){
			$srcImg=imagecreatefrompng($imageName);
		}else{
			$srcImg=imagecreatefromjpeg($imageName);
		};
		if(!$srcImg){return null;};
	
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

		return $wwwFile;
	}

	public function getFileExtension($name){
		$lastdot = strrpos($name, '.');
		if (!($lastdot === FALSE)) {
			return substr($name, $lastdot + 1);
		};
		return null;
	}

}
