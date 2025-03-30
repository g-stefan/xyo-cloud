<?php                                                                   
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT


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
	$sourceId.="\"".$value[$this->primaryKey]."\"";
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
$instanceJS.="XYO.Table.nonce=\"".$this->getCSPNonce()."\";";

$this->setHtmlJsSourceOrAjax($instanceJS,"load");
$this->setHtmlJsSourceOrAjaxCsrfToken();
