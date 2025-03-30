<?php
// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2020-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: Unlicense

function getFileAndDirectoryList($superPath, $path="", $prefix="") {
	$this_ = array();
	if (!$dh = @opendir($superPath.$prefix.$path)) {
		return $this_;
	};
	while (false !== ($obj = readdir($dh))) {
		if ($obj == '.' || $obj == '..') {
			continue;
		};
		array_push($this_, $path.$obj);
		if (is_dir($superPath."/".$path.$obj)){
			$this_=array_merge($this_, getFileAndDirectoryList($superPath, $path.$obj."/", "/"));
		};
	};
	closedir($dh);
	return $this_;
};

function getFileListHash($superPath,$list) {
	if(strlen(trim($superPath))==0){
		return;
	};
	$retV=array();
	foreach($list as $key=>$value){
		if(!is_dir($superPath."/".$value)){
			$retV[$key]=hash_file("sha512",$superPath."/".$value,false);
		}else{
			$retV[$key]="directory";
		};
	};
	return $retV;
};

function arrayCopyFlip($list){
	$retV=array();
	foreach($list as $key=>$value){
		$retV[$value]=$key;
	};
	return $retV;
};

function makeModifiedList($lastFiles,$lastHash,$latestFiles,$latestHash){
	$retV=array();
	$latestFilesFilp=arrayCopyFlip($latestFiles);
	foreach($lastFiles as $key=>$value){
		if(array_key_exists($value,$latestFilesFilp)){
			if(strcmp($lastHash[$key],$latestHash[$latestFilesFilp[$value]])){
				$retV[$latestFilesFilp[$value]]=$value;
			};
		};
	};
	return $retV;
};

function makeAddedList($lastFiles,$latestFiles){
	$retV=array();
	$lastFilesFilp=arrayCopyFlip($lastFiles);
	foreach($latestFiles as $key=>$value){
		if(!array_key_exists($value,$lastFilesFilp)){
			$retV[$key]=$value;
		};
	};
	return $retV;
};

function makeRemovedList($lastFiles,$latestFiles) {
	return makeAddedList($latestFiles,$lastFiles);
};

function removeDirectory($superPath, $path="", $prefix="") {
	if (!$dh = @opendir($superPath.$prefix.$path)) {
		return;
	};
	while (false !== ($obj = readdir($dh))) {
		if ($obj == '.' || $obj == '..') {
			continue;
		};
		if (is_dir($superPath."/".$path.$obj)){
			removeDirectory($superPath, $path.$obj."/", "/");
		} else {
			unlink($superPath."/".$path.$obj);
		};
	};
	closedir($dh);
	rmdir($superPath.$prefix.$path);
};

function copyFileOrDirectory($sourcePath,$destinationPath,$fileName) {
	if(is_dir($sourcePath."/".$fileName)){
		mkdir($destinationPath."/".$fileName,0777,true);
		return;
	};
	if(dirname($fileName)!="."){
		if(!is_dir($destinationPath."/".dirname($fileName))){
			mkdir($destinationPath."/".dirname($fileName),0777,true);
		};
	};
	copy($sourcePath."/".$fileName,$destinationPath."/".$fileName);
};

//

$pathBase=$argv[1];
$versionLast=$argv[2];
$versionLatest=$argv[3];

echo "path base: ".$pathBase."\n";
echo "version last: ".$versionLast."\n";
echo "version latest: ".$versionLatest."\n";

$pathLast=$pathBase."-".$versionLast;
$pathLatest=$pathBase."-".$versionLatest;

if(!is_dir($pathLast)){
	echo "Error: directory ".$pathLast." not found!\n";
	exit(1);
};

if(!is_dir($pathLatest)){
	echo "Error: directory ".$pathLatest." not found!\n";
	exit(1);
};

//

$lastFileList=getFileAndDirectoryList($pathLast);
$latestFileList=getFileAndDirectoryList($pathLatest);

//
//print_r($lastFileList);
//print_r($latestFileList);
//

$lastFileListHash=getFileListHash($pathLast,$lastFileList);
$latestFileListHash=getFileListHash($pathLatest,$latestFileList);

//

$modifiedList=makeModifiedList($lastFileList,$lastFileListHash,$latestFileList,$latestFileListHash);
$addedList=makeAddedList($lastFileList,$latestFileList);
$removedList=makeRemovedList($lastFileList,$latestFileList);
rsort($removedList);

//
//print_r($modifiedList);
//print_r($addedList);
//print_r($removedList);
//

echo "modified files: ".count($modifiedList)."\n";
echo "added files/folders: ".count($addedList)."\n";
echo "removed files/folders: ".count($removedList)."\n";

//
$updatePath=$pathBase."-update-".$versionLast."-to-".$versionLatest;
//

if(is_dir($updatePath)){
	removeDirectory($updatePath);
};

mkdir($updatePath);

//

foreach($modifiedList as $key=>$value){
	copyFileOrDirectory($pathLatest,$updatePath,$value);
};

foreach($addedList as $key=>$value){
	copyFileOrDirectory($pathLatest,$updatePath,$value);
};

if(count($removedList)){

	$removeSource="<"."?"."php\n\n";
	$removeSource.="// !!! Automatically generated !!!\n";
	$removeSource.="// Public domain\n";
	$removeSource.="// http://unlicense.org/\n";

	foreach($removedList as $key=>$value) {
		if(is_dir($pathLast."/".$value)){
			$removeSource.="rmdir(\"".addslashes($value)."\");\n";
		}else{
			$removeSource.="unlink(\"".addslashes($value)."\");\n";
		};
	};

	file_put_contents($updatePath."/update-removed-files-or-folders-from-".$versionLast."-to-".$versionLatest.".php",$removeSource);

};

echo "done.\n";
