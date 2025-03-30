<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$rnd=$this->getParameterRequest("rnd",hash("sha512",time().rand(),false));
$prefix=$this->getParameterRequest("prefix","xui_image_captcha");

// safe characters no visual colision
$cpatchaChr="23456789abcdefhijkmnpqrstuvwxyz";
              
$captchaFont=$this->getCloudPath()."lib/roboto-regular.woff";
$captchaFontSz=32; //32points
$captchaImgW=200; //px
$captchaImgH=48;  //px
$captchaMarginW=9; //px
$captchaMarginH=9; //px
$captchaImg=imagecreatetruecolor($captchaImgW,$captchaImgH);
imagealphablending($captchaImg,true);    
$bkgColor=imagecolorallocate($captchaImg, 0xFF, 0xFF, 0xFF);
$pixColor=imagecolorallocate($captchaImg, 0x00, 0x00, 0x00);

$captchaLn=strlen($cpatchaChr)-1;
$captchaStr=array();
for($k=0;$k<5;++$k){
	$chIndex=rand(0,$captchaLn);
	$captchaStr[$k]=substr($cpatchaChr,$chIndex,1);
};

$captchaSz=array();
for($k=0;$k<5;++$k){
	$rectPt=imagettfbbox($captchaFontSz,0,$captchaFont,$captchaStr[$k]);
	$captchaSz[$k]=array("w"=>($rectPt[2]-$rectPt[6]),"h"=>($rectPt[3]-$rectPt[7]));
};

$maxW=0;
for($k=0;$k<5;++$k){
	if($captchaSz[$k]["w"]>$maxW){
		$maxW=$captchaSz[$k]["w"];
	};
};

$maxH=0;
for($k=0;$k<5;++$k){
	if($captchaSz[$k]["h"]>$maxH){
		$maxH=$captchaSz[$k]["h"];
	};
};

$imgH=floor(($captchaImgH-2*$captchaMarginH-$maxH)/2)+$maxH+$captchaMarginH/2;
$spaceW=floor(($captchaImgW-5*$maxW-2*$captchaMarginW)/4);

imagefilledrectangle($captchaImg, 0, 0, $captchaImgW, $captchaImgH, $bkgColor);

for($k=0;$k<5;++$k){
	$fontColor=imagecolorallocatealpha($captchaImg, 0x00, 0x00, 0x00,rand(0,32));
	imagefttext($captchaImg,$captchaFontSz,30-rand(0,60),$captchaMarginW+$k*($maxW+$spaceW),$imgH,$fontColor,$captchaFont,$captchaStr[$k]);
};

// effect on letters
imagesetthickness($captchaImg,1);
for($k=0;$k<5;++$k){
	$pixColor=imagecolorallocatealpha($captchaImg, 0x00, 0x00, 0x00,rand(64,127));
	imageline($captchaImg,$captchaMarginW+$k*($maxW+$spaceW)+rand(0,($maxW+$spaceW)),0,$captchaMarginW+$k*($maxW+$spaceW)+rand(0,($maxW+$spaceW)),$captchaImgH,$pixColor);
};
$pixColor=imagecolorallocatealpha($captchaImg, 0x00, 0x00, 0x00,rand(64,127));
imageline($captchaImg,0,rand(0,$captchaImgH),$captchaImgW,rand(0,$captchaImgH),$pixColor);
$pixColor=imagecolorallocatealpha($captchaImg, 0x00, 0x00, 0x00,rand(64,127));
imageline($captchaImg,0,rand(0,$captchaImgH),$captchaImgW,rand(0,$captchaImgH),$pixColor);

// some noise
for($j=0;$j<8;++$j){
	$pixColor=imagecolorallocatealpha($captchaImg, 0x00, 0x00, 0x00,rand(0,127));
	imagesetthickness($captchaImg,1);
	for($k=0;$k<32;$k++){
		$sx=rand(0,$captchaImgW);
		$sy=rand(0,$captchaImgH);
		$dx=16-rand(0,32);
		$dy=16-rand(0,32);
		imageline($captchaImg,$sx,$sy,$sx+$dx,$sy+$dy,$pixColor);
	};
};

// some noise
for($j=0;$j<8;++$j){
	$pixColor=imagecolorallocatealpha($captchaImg, 0x00, 0x00, 0x00,rand(0,127));
	imagesetthickness($captchaImg,1);
	for($k=0;$k<32;$k++){
		$sx=rand(0,$captchaImgW);
		$sy=rand(0,$captchaImgH);
		imagesetpixel($captchaImg,$sx,$sy,$pixColor);
	};
};

$_SESSION[$prefix."_captcha_rnd"]=$rnd;
$_SESSION[$prefix."_captcha_key"]=hash("sha512",$rnd.hash("sha512",implode("",$captchaStr),false),false);

header("Content-Type: image/jpeg");
imagejpeg($captchaImg);

imagedestroy($captchaImg);

