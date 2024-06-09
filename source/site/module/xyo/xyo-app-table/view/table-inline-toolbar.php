<?php
// Copyright (c) 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$toolbar_id="xui-app-toolbar_content";
if($this->isInlineForm){
	$toolbar_id="xui-app-toolbar_content_right";
};
//echo 	$this->getCsrfTokenJsSource();
echo	"var loader=\"<div class=\\\"xui xyo-app-table -x-inline-toolbar-1\\\"><div class=\\\"xui center-xy xyo-app-table -x-inline-toolbar-2\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
	"\$(\"#".$toolbar_id."\").html(loader);".
	"\$.post(\"".$this->requestUriThis()."\", { ".$this->instanceV."action: \"".$this->getArgument("action","table-inline-view-toolbar")."\", ajax: 1, csrf_token: window.csrfToken, csp_nonce: \"".$this->getCSPNonce()."\" })".
  	".done(function(response){".		
		"XUI.HTML.update(\"".$toolbar_id."\",response,\"".$this->getCSPNonce()."\");".
	"});";
