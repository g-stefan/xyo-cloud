<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$toolbar_id="xui-app-toolbar_content";
if($this->isInlineForm){
	$toolbar_id="xui-app-toolbar_content_right";
};
//echo 	$this->getCsrfTokenJsSource();
echo	"var loader=\"<div class=\\\"xui xyo-app-table -x-inline-toolbar-1\\\"><div class=\\\"xui center-xy xyo-app-table -x-inline-toolbar-2\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
	"\$(\"#".$toolbar_id."\").html(loader);".
	"\$.post(\"".$this->requestUriThis()."\", { ".$this->instanceV."action: \"".$this->getArgument("action","table-inline-view-toolbar")."\", ajax: 1, csrf_token: window.csrfToken })".
  	".done(function(result){".
		"var jsAndHtml=XUI.Html.extractScript(result);".
		"\$(\"#".$toolbar_id."\").html(jsAndHtml.html);".
		"\$(\"#".$toolbar_id."\").append(jsAndHtml.js);".
	"});";
