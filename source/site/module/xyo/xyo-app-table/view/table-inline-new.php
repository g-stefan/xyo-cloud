<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setCsrfReferenceCount(3);
$this->setHtmlJsSourceOrAjaxCsrfToken();
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

$this->ecssBegin();
echo ".xyo-app-table.--x-inline-new-1{position:relative;width:100%;min-height:240px;}";
echo ".xyo-app-table.--x-inline-new-2{height:240px;}";
$this->ecssEnd();

$this->ejsBegin();
echo "window.".$this->instanceV."doCommandInlineForm=function(action){".
	"var loader=\"<div class=\\\"xyo-app-table --x-inline-new-1\\\"><div class=\\\"flex flex-col items-center justify-center xyo-app-table --x-inline-new-2\\\"><div class=\\\"xui-animated-loader\\\"></div></div></div>\";".
	"\$(\"#".$this->getFormName()."\").ajaxForm({url: \"".$this->cloud->requestUriModule($this->name)."\", type: \"post\", data:{csrf_token:window.csrfToken, csp_nonce: \"".$this->getCSPNonce()."\"}, success: function(response){".
		"setTimeout(function(){".			
			"XUI.HTML.update(\"xyo-app-table-inline_content\",response,\"".$this->getCSPNonce()."\");".
			"XUI.EffectRipple.create(document.getElementById(\"xyo-app-table-inline_content\").getElementsByClassName(\"xui-effect-ripple\"));".
		"},100)".
	"}});".
	"\$(\"#".$this->getFormName()."\").submit();".
	"\$(\"#xyo-app-table-inline_content\").html(loader);".
	"return false;".
	"};";
$this->ejsEnd();
