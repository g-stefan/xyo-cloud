<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$id = $this->getArgument("id","inline");
$jsFunction = $this->getArgument("jsFunction","cmdInline");
$jsButtonClick = $this->getArgument("jsButtonClick","");
$jsButtonCancel = $this->getArgument("jsButtonCancel","");
$formSuffix= $this->getArgument("formSuffix","inline");
$action= $this->getArgument("action","inline");
$instance = $this->getArgument("instance","");
$hasCancel = $this->getArgument("hasCancel",0);
$noHtml = $this->getArgument("noHtml",false);

$instanceV = "";
if(strlen($instance)>0){
	$instanceV = $instance."_";
};

if(strlen($formSuffix)){
	$formSuffix="_".$formSuffix;
};

$this->ecssBegin();
echo ".xui-com-inline.--loader{position:relative;width:100%;min-height:240px;}";
echo ".xui-com-inline.--div-1{height:240px;}";
echo ".xui-com-inline.--div-2{display:none;height:100%;width:100%;overflow:auto;}";
$this->ecssEnd();


if(strlen($jsButtonClick)==0){
	$originalFormName=$this->getFormName();
	$this->setFormName($originalFormName.$formSuffix);
	$jsButtonClick=	"var loader=\"<div class=\\\"xui-com-inline --loader\\\"><div class=\\\"flex flex-col items-center justify-center xui-com-inline --div-1\\\"><div class=\\\"xui-animated-loader\\\"></div></div></div>\";".
			"\$(\"#".$this->getFormName()."\").ajaxForm({url: \"".$this->cloud->requestUriModule($this->name)."\", type: \"post\", data: {csrf_token:window.csrfToke, csp_nonce: \"".$this->getCSPNonce()."\"}, success: function(response){".
				"setTimeout(function(){".				
				"XUI.HTML.update(\"".$id."_content\",response,\"".$this->getCSPNonce()."\");".
				"},100)".
			"}});".
			"\$(\"#".$this->getFormName()."\").submit();".
			"\$(\"#".$id."_content\").html(loader);";
	$this->setFormName($originalFormName);
};

if(!$noHtml) {
	echo "<div id=\"".$id."\" class=\"xui-overlay-scrollbars xui-com-inline --div-2\">";
		echo "<div id=\"".$id."_content\" class=\"xui\"></div>";
	echo "</div>";
};

$this->setHtmlJsSourceOrAjax(
	"window.".$jsFunction."=function(jsParameters){".
		"var jsAction= { ".$instanceV."action: \"".$action."\", ajax: 1, csrf_token: window.csrfToken, csp_nonce: \"".$this->getCSPNonce()."\" };".
		"if(jsParameters){ for (var x in jsParameters) { jsAction[x] = jsParameters[x]; }; };".
		"var loader=\"<div class=\\\"xui-com-inline --loader\\\"><div class=\\\"flex flex-col items-center justify-center xui-com-inline --div-1\\\"><div class=\\\"xui-animated-loader\\\"></div></div></div>\";".
		"\$(\"#".$id."_content\").html(loader);".
		"\$(\"#".$id."\").show();".
		"\$.post(\"".$this->requestUriThis()."\", jsAction)".
  		".done(function(response){".			
			"XUI.HTML.update(\"".$id."_content\",response,\"".$this->getCSPNonce()."\");".
		"});".
	"};".
	"\r\n".
	"window.".$jsFunction."Click=function(){".
		$jsButtonClick.
	"};".
	"\r\n".
	"window.".$jsFunction."Cancel=function(){".
		$jsButtonCancel.
	"};".
	"\r\n"
,"load");
