<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->generateView("notify-alert");
$this->generateView("notify-error");

// ---
$this->ejsBegin();
$this->generateView("table-inline-toolbar",array("action"=>"table-inline-new-toolbar"));
$this->ejsEnd();
// ---

$this->setParameter("form.title","form.title_new");
$this->generateComponent("xui.form-action-begin");
$this->generateView("form");
$this->generateComponent("xui.form-action-end",array(
	"parameters"=>array(
		$this->getInstanceName("action")=>"table-inline-new-apply",
		"ajax"=>1
	)
));

$this->ejsBegin();
echo "window.".$this->instanceV."doCommandInlineForm=function(action){".
	"var loader=\"<div class=\\\"xui\\\" style=\\\"position:relative;width:100%;min-height:240px;\\\"><div class=\\\"xui center-xy\\\" style=\\\"height:240px;\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
	"\$(\"#".$this->getFormName()."\").ajaxForm({url: \"".$this->cloud->requestUriModule($this->name)."\", type: \"post\", success: function(response){".
		"setTimeout(function(){".
		"var jsAndHtml=XUI.Html.extractScript(response);".
		"\$(\"#xyo-app-table-inline_content\").html(jsAndHtml.html);".
		"\$(\"#xyo-app-table-inline_content\").append(jsAndHtml.js);".
		"},100)".
	"}});".
	"\$(\"#".$this->getFormName()."\").submit();".
	"\$(\"#xyo-app-table-inline_content\").html(loader);".
	"return false;".
	"};";
$this->ejsEnd();
