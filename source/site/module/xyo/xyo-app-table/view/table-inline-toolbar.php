<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

echo	"var loader=\"<div class=\\\"xui\\\" style=\\\"position:relative;width:100%;min-height:240px;\\\"><div class=\\\"xui center-xy\\\" style=\\\"height:240px;\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
	"\$(\"#xui-app-toolbar_content\").html(loader);".
	"\$.post(\"".$this->requestUriThis()."\", { ".$this->instanceV."action: \"".$this->getArgument("action","table-inline-view-toolbar")."\", ajax: 1 })".
  	".done(function(result){".
		"var jsAndHtml=XUI.extractScript(result);".
		"\$(\"#xui-app-toolbar_content\").html(jsAndHtml.html);".
		"\$(\"#xui-app-toolbar_content\").append(jsAndHtml.js);".
	"});";
	//"XYO.Table.checkboxOnlyOneById('".$this->instance."');";
