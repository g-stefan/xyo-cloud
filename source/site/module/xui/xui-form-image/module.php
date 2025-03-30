<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xui_FormImage";

class xui_FormImage extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
	}

	public function getImageInfo($value){
		if(is_null($value) || (strlen($value)==0)){
			return array();
		};

		$list=str_getcsv($value,",","\"","\\");
		$retV=array();

		$retV["fileName"]=$list[0];
		$retV["offsetX"]=0;
		$retV["offsetY"]=0;
		$retV["zoom"]=1;
		$retV["imageWidth"]=320;
		$retV["imageHeight"]=240;
		$retV["viewX"]=320;
		$retV["viewY"]=240;
		$retV["hash"]="";

		if(count($list)>1){
			$retV["offsetX"]=$list[1];
			$retV["offsetY"]=$list[2];
			$retV["zoom"]=$list[3];
			$retV["imageWidth"]=$list[4];
			$retV["imageHeight"]=$list[5];
			$retV["viewX"]=$list[6];
			$retV["viewY"]=$list[7];			
			$retV["hash"]=$list[8];
		};

		return $retV;
	}

	public function eImageCss($value){
		if(strlen($value)==0){
			return;
		};


		$list=str_getcsv($value,",","\"","\\");
		
		$fileName = $list[0];

		if(strlen($fileName)==0){
			return;
		};

		//echo "/* ".$value." */\r\n";

		$offsetX = 0;
		$offsetY = 0;
		$zoom = 1;
		$imageWidth = 320;
		$imageHeight = 240;
		$viewX = 320;
		$viewY = 240;

		if(count($list)>1) {
			$offsetX = $list[1];
			$offsetY = $list[2];
			$zoom = $list[3];
			$imageWidth = $list[4];
			$imageHeight = $list[5];
			$viewX = $list[6];
			$viewY = $list[7];
		};

		if(1*$zoom==0){
			$zoom=1;
		};
		                                
		if((substr($fileName, 0, 4) === "http")||
		(substr($fileName, 0, 5) === "data:")){
			echo "\tbackground-image: url(\"".$fileName."\");\r\n";
		} else {
			echo "\tbackground-image: url(\"".$this->site.$fileName."\");\r\n";
		};
		echo "\tbackground-size: ".number_format((100*$zoom*$imageWidth)/$viewX,2,".","")."% auto;\r\n";

		$posX=-$offsetX;
		$factorX=$imageWidth*$zoom-$viewX;
		if($factorX==0){
			$posX=0;
			$factorX=1;
		};
		$posY=-$offsetY;
		$factorY=$imageHeight*$zoom-$viewY;
		if($factorY==0){
			$posY=0;
			$factorY=1;
		};		

		echo "\tbackground-position: ".number_format((100*$posX)/$factorX,2,".","")."% ".number_format((100*$posY)/$factorY,2,".","")."%;\r\n";
		echo "\tbackground-repeat: no-repeat;\r\n";

		echo "\twidth: 100%;\r\n";
		echo "\theight: 0px;\r\n";
		echo "\tpadding-bottom: ".number_format((100*$viewY)/$viewX,2,".","")."%;\r\n";
	}

}
