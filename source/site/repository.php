<?php
// 
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//
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
header("Content-Type: ".$mimeContentType);
header("Content-Length: ".filesize($file));

readfile($file);
