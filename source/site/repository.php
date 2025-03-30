<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT
require("xyo/xyo-cloud-instance.php");
defined("XYO_CLOUD") or die("Access is denied");
define("XYO_CLOUD_REPOSITORY",1);
// ---
// start up session - cookie only
ini_set("session.use_cookies", 1);
ini_set("session.use_trans_sid", 0);
session_start();
// ---
$this->includeConfigWithPattern("xyo-cloud");
$this->setSiteFromServerRequest();
$repositoryPath=$this->get("repository_path","repository");
//
// Allow access only for authenticated users
//
$modUser=&$this->getModule("xyo-mod-ds-user");
if(!$modUser->isAuthorized()) {
	http_response_code(404);
	die();
};

$fileName=trim($this->request->get("__",""));
if(strlen($fileName)==0) {
	http_response_code(404);
	die();	
};

$file=$repositoryPath."/".$fileName;
if(!file_exists($file)) {
	http_response_code(404);
	die();
};

$mimeContentType=mime_content_type($file);
if($mimeContentType===false){
	$mimeContentType="application/octet-stream";
};

$length = filesize($file);
$fileSize = $length;
$bufferSize = 1024*1024; //1MB

$fp = fopen($file, "r");
if($fp===false){
	http_response_code(404);
	die();
};

if (!array_key_exists("HTTP_RANGE",$_SERVER)) {

	header("Accept-Ranges: bytes");
	header("Content-Disposition: inline; file=\"".basename($fileName)."\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".$fileSize);
	header("Content-Type: ".$mimeContentType);

	fseek($fp,0);	
	while($length>=$bufferSize) {
		print(fread($fp, $bufferSize));
		$length -= $bufferSize;
	};
	if ($length){
		print(fread($fp, $length));
	};
	fclose($fp);

	die();
};

$rangeInfo = explode("bytes=",$_SERVER["HTTP_RANGE"]);
if(count($rangeInfo)<2) {
	http_response_code(404);
	die();
};
$rangeInfoList=explode(",",trim($rangeInfo[1]));
$rangeList=array();
foreach($rangeInfoList as $range){
	$info=explode("-",trim($range));
	if(count($info)<2){
		http_response_code(404);
		die();
	};
	$begin=0;
	$end=$length-1;
	$rangeBegin=trim($info[0]);
	$rangeEnd=trim($info[1]);
	if(strlen($rangeBegin)) {
		$begin = intval($rangeBegin);
		if($begin < 0){
			$begin=0;
		};
	};
	if(strlen($rangeEnd)) {
		$end = intval($rangeBegin);
		if($end >= $length) {
			$end = $length-1;
		};
	};
	if(strlen($rangeBegin)==0) {
		$begin = $end;
		$end = $length-1;
	};
	if($begin < 0){
		$begin=0;
	};
	if($end >= $length) {
		$end = $length-1;
	};
	if($end<$begin) {
		http_response_code(404);
		die();
	};
	array_push($rangeList, array($begin,$end));
};

// ---

if(count($rangeList)==0){
	http_response_code(404);
	die();	
};

if(count($rangeList)==1) {
	$length = $rangeList[0][1]-$rangeList[0][0]+1;

	header("HTTP/1.1 206 Partial Content");
	header("Accept-Ranges: bytes");
	header("Content-Disposition: inline; file=\"".basename($fileName)."\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Range: bytes ".$rangeList[0][0]."-".$rangeList[0][1]."/".$fileSize);
	header("Content-Length: ".$length);
	header("Content-Type: ".$mimeContentType);
	
	fseek($fp,$rangeList[0][0]);
	while($length>=$bufferSize) {
		print(fread($fp, $bufferSize));
		$length -= $bufferSize;
	};
	if ($length){
		print(fread($fp, $length));
	};
	fclose($fp);

	die();
};

$boundary="===={CA538371-7576-4C18-9390-D6AE13B2C897}====";

header("HTTP/1.1 206 Partial Content");
header("Accept-Ranges: bytes");
header("Content-Disposition: inline; file=\"".basename($fileName)."\"");
header("Content-Transfer-Encoding: binary");
header("Content-Type: multipart/byteranges; boundary=".$boundary);

foreach($rangeList as $range) {
	$length = $range[1]-$range[0]+1;
	echo "--".$boundary."\r\n";
	echo "Content-Range: bytes ".$range[0]."-".$range[1]."/".$fileSize."\r\n";
	echo "Content-Length: ".$length."\r\n";
	echo "Content-Type: ".$mimeContentType."\r\n";
	echo "\r\n";

	fseek($fp,$range[0]);
	while($length>=$bufferSize) {
		print(fread($fp, $bufferSize));
		$length -= $bufferSize;
	};
	if ($length) {
		print(fread($fp, $length));
	};
};
echo "--".$boundary."--\r\n";
fclose($fp);

die();
