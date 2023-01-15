<?php
// Copyright (c) 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$id = $this->getArgument("id","modal");
$jsFunction = $this->getArgument("jsFunction","cmdModal");
$formSuffix= $this->getArgument("formSuffix","modal");
$action= $this->getArgument("action","modal");
$instance = $this->getArgument("instance","");

$instanceV = "";
if(strlen($instance)>0){
	$instanceV = $instance."_";
};

if(strlen($formSuffix)){
	$formSuffix="_".$formSuffix;
};

$this->ecssBegin();
echo ".-com-modal.-loader{position:relative;width:100%;min-height:240px;}";
echo ".-com-modal.-div-1{height:240px;}";
$this->ecssEnd();
?>
<div id="<?php echo $id; ?>" class="xui modal">
	<div class="xui panel _modal-content -overlay-scrollbars os-host-flexbox">
		<div class="xui _modal-close-button button -icon -size-x32 -circle -danger -transparent -effect-ripple"><i class="material-icons">close</i></div>
		<div class="xui panel_content" id="<?php echo $id; ?>_content"></div>
	</div>
</div>
<?php

$this->setHtmlJsSourceOrAjax(
	"window.".$jsFunction."=function(jsParameters){".
		"var jsAction= { ".$instanceV."action: \"".$action."\", ajax: 1, csrf_token: window.csrfToken, csp_nonce: \"".$this->getCSPNonce()."\" };".
		"if(jsParameters){ for (var x in jsParameters) { jsAction[x] = jsParameters[x]; }; };".
		"var loader=\"<div class=\\\"xui -com-modal -loader\\\"><div class=\\\"xui center-xy -com-modal -div-1\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
		"\$(\"#".$id."_content\").html(loader);".
		"XUI.Modal.activate(\"".$id."\");".
		"\$.post(\"".$this->requestUriThis()."\", jsAction)".
  		".done(function(response){".
			"XUI.Html.update(\"".$id."_content\",response,null,\"".$this->getCSPNonce()."\");".
		"});".
	"};".
	"\r\n"
,"load");
$this->setHtmlJsSourceOrAjax("\$(\"body\").append(\$(\"#".$id."\").detach());","load");
if($this->isAjax()){
	$this->setHtmlJsSourceOrAjax(
	"XUI.OverlayScrollbars.create(\$(\"#".$id." .xui.-overlay-scrollbars\"));".
	"\$(\"#".$id." ._modal-close-button\").click(function(){XUI.Modal.deactivate();});"
	,"load");
};
$this->setHtmlJsSourceOrAjaxCsrfToken();
