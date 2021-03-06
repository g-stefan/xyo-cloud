<?php                                                                   
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$instanceJS="XYO.Table.instance[\"".$this->instance."\"]={";

$sourceId="id:[";
$count_=count($this->viewData);
$itemComa=false;
foreach ($this->viewData as $key => $value) {
	if($itemComa){
		$sourceId.=",";
	}else{
		$itemComa=true;
	};
	$sourceId.=$value[$this->primaryKey];
};
$sourceId.="],";

$instanceJS.=$sourceId;
$instanceJS.="form:document.forms.".$this->getFormName().",";
$instanceJS.="instanceV:\"".$this->instanceV."\",";
if($this->isEmbedded){
	$instanceJS.="embedded:true,";
}else{
	$instanceJS.="embedded:false,";
};
$instanceJS.="uri:\"".$this->requestUriThis()."\"";
$instanceJS.="};";

$this->setHtmlJsSourceOrAjax($instanceJS,"load");
