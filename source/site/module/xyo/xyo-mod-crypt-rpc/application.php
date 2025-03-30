<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

//
//  input signed request
//
//  {
//    "run"=>"module",
//    "name1":"value1",
//    "name2":"value2", ...
//  }
//

//
//  output signed result
//

header("Content-Type: application/json");

$GLOBALS["xyo_mod_CryptRPC__privateKey"]=$this->cloud->get("crypt_rpc_private_key","unknown");
if(strcmp($GLOBALS["xyo_mod_CryptRPC__privateKey"],"unknown")==0){
	$result="{\"error\":\"invalid settings #0\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

$request = json_decode(file_get_contents("php://input"),true);
if(!$request){
	$result="{\"error\":\"invalid request #0\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

$dataJSON="";
if(!xyo_Crypt::privateDecrypt($GLOBALS["xyo_mod_CryptRPC__privateKey"],base64_decode($request["process"]),$dataJSON)){
	$result="{\"error\":\"invalid request #1\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

if(strlen($dataJSON)==0){
	$result="{\"error\":\"invalid request #2\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

$process=json_decode($dataJSON);
if(!$process){
	$result="{\"error\":\"invalid request #3\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

if(!is_object($process)){
	$result="{\"error\":\"invalid request #4\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

$this->cloud->setRequest("run","");

foreach($process as $key=>$value){
	$this->cloud->setRequest($key,$value);
};

$module_=trim($this->cloud->getRequest("run",""));
if(strlen($module_)==0){
	$result="{\"error\":\"invalid request #5\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

$module=$this->cloud->loadModuleRunPath($module_);
if(!$module){
	$result="{\"error\":\"invalid request #6\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

$moduleX=&$this->getModule($module);
if(!$moduleX){
	$result="{\"error\":\"invalid request #7\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
	return;
};

$this->cloud->setRequest("json",1);

ob_start();
function _process__on_shutdown(){
	$retV=ob_get_contents();
	ob_end_clean();
	$output="";
	if(xyo_Crypt::privateEncrypt($GLOBALS["xyo_mod_CryptRPC__privateKey"],$retV,$output)){
		$json="{\r\n\t\"result\" : \"".base64_encode($output)."\"\r\n}";
		header("Content-length: ".strlen($json). "\r\n");
		echo $json;	
		return;
	};
	$result="{\"error\":\"invalid request #8\"}\r\n";
	header("Content-Length: ".strlen($result));
	echo $result;
};
register_shutdown_function("_process__on_shutdown");

$this->runModule($module_);
