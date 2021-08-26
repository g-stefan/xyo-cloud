<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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

if(strlen($jsButtonClick)==0){
	$originalFormName=$this->getFormName();
	$this->setFormName($originalFormName.$formSuffix);
	$jsButtonClick=	"var loader=\"<div class=\\\"xui\\\" style=\\\"position:relative;width:100%;min-height:240px;\\\"><div class=\\\"xui center-xy\\\" style=\\\"height:240px;\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
			"\$(\"#".$this->getFormName()."\").ajaxForm({url: \"".$this->cloud->requestUriModule($this->name)."\", type: \"post\", data: {csrf_token:window.csrfToken}, success: function(response){".
				"setTimeout(function(){".
				"var jsAndHtml=XUI.Html.extractScript(response);".
				"\$(\"#".$id."_content\").html(jsAndHtml.html);".
				"\$(\"#".$id."_content\").append(jsAndHtml.js);".
				"},100)".
			"}});".
			"\$(\"#".$this->getFormName()."\").submit();".
			"\$(\"#".$id."_content\").html(loader);";
	$this->setFormName($originalFormName);
};

if(!$noHtml) {
	echo "<div id=\"".$id."\" class=\"xui -overlay-scrollbars\" style=\"display:none;height:100%;width:100%;overflow:auto;\">";
		echo "<div id=\"".$id."_content\" class=\"xui\"></div>";
	echo "</div>";
};

$this->setHtmlJsSourceOrAjax(
	"window.".$jsFunction."=function(jsParameters){".
		"var jsAction= { ".$instanceV."action: \"".$action."\", ajax: 1, csrf_token: window.csrfToken  };".
		"if(jsParameters){ for (var x in jsParameters) { jsAction[x] = jsParameters[x]; }; };".
		"var loader=\"<div class=\\\"xui\\\" style=\\\"position:relative;width:100%;min-height:240px;\\\"><div class=\\\"xui center-xy\\\" style=\\\"height:240px;\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
		"\$(\"#".$id."_content\").html(loader);".
		"\$(\"#".$id."\").show();".
		"\$.post(\"".$this->requestUriThis()."\", jsAction)".
  		".done(function(result){".
			"var jsAndHtml=XUI.Html.extractScript(result);".
			"\$(\"#".$id."_content\").html(jsAndHtml.html);".
			"\$(\"#".$id."_content\").append(jsAndHtml.js);".
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
