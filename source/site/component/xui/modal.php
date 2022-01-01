<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$id = $this->getArgument("id","modal");
$button = $this->getArgument("button","Action");
$buttonType = $this->getArgument("buttonType","primary");
$jsFunction = $this->getArgument("jsFunction","cmdModal");
$jsButtonClick = $this->getArgument("jsButtonClick","");
$jsButtonCancel = $this->getArgument("jsButtonCancel","");
$formSuffix= $this->getArgument("formSuffix","modal");
$action= $this->getArgument("action","modal");
$instance = $this->getArgument("instance","");
$noTitle = $this->getArgument("no-title",0);
$hasCancel = $this->getArgument("hasCancel",0);
$instanceV = "";
if(strlen($instance)>0){
	$instanceV = $instance."_";
};

$formTitle=$this->getParameter("form_title");
$title=$this->getArgument("title","");
if($title=="form_title"){
	$title=$formTitle;
};
if(strlen($title)>0){
	$title=$this->getFromLanguage($title);
};
$title=$this->getArgument("title-text",$title);
if(strlen($title)==0){
	$noTitle=1;
};

if(strlen($formSuffix)){
	$formSuffix="_".$formSuffix;
};
if(strlen($buttonType)){
	$buttonType="-".$buttonType;
};
if(strlen($jsButtonClick)==0){
	$originalFormName=$this->getFormName();
	$this->setFormName($originalFormName.$formSuffix);
	$jsButtonClick="\$(\"#".$this->getFormName()."\").ajaxForm({url: \"".$this->cloud->requestUriModule($this->name)."\", type: \"post\", data: {csrf_token:window.csrfToken}, success: function(response){".
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

?>
<div id="<?php echo $id; ?>" class="xui modal">
	<div class="xui panel _modal-content -overlay-scrollbars os-host-flexbox">
		<div class="xui _modal-close-button button -icon -size-x32 -circle -danger -transparent -effect-ripple"><i class="material-icons">close</i></div>
		<?php if(!$noTitle){ ?>
		<div class="xui panel_title">
			<?php echo $title; ?>
		</div>
		<div class="xui panel_line"></div>
		<?php }; ?>
		<div class="xui panel_content" id="<?php echo $id; ?>_content"></div>
		<div class="xui panel_line"></div>
		<div class="xui panel_footer">
<?php if($hasCancel){ ?>
			<button type="button" class="xui button -outline -danger -left" id="<?php echo $id; ?>_cancel">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage("cancel"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
<?php }; ?>
			<button type="button" class="xui button <?php echo $buttonType; ?> -right" id="<?php echo $id; ?>_button">&nbsp;&nbsp;&nbsp;&nbsp;<?php $this->eLanguage($button); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
		</div>
	</div>
</div>
<?php

$this->setHtmlJsSourceOrAjax(
	"window.".$jsFunction."=function(jsParameters){".
		"var jsAction= { ".$instanceV."action: \"".$action."\", ajax: 1, csrf_token: window.csrfToken };".
		"if(jsParameters){ for (var x in jsParameters) { jsAction[x] = jsParameters[x]; }; };".
		"var loader=\"<div class=\\\"xui\\\" style=\\\"position:relative;width:100%;min-height:240px;\\\"><div class=\\\"xui center-xy\\\" style=\\\"height:240px;\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
		"\$(\"#".$id."_content\").html(loader);".
		"XUI.Modal.activate(\"".$id."\");".
		"\$.post(\"".$this->requestUriThis()."\", jsAction)".
  		".done(function(result){".
			"\$(\"#".$id."_button\").off(\"click\").on(\"click\",function(){".
				$jsButtonClick.
			"});".
			(($hasCancel)?"\$(\"#".$id."_cancel\").off(\"click\").on(\"click\",function(){".$jsButtonCancel."});":"").
			"var jsAndHtml=XUI.Html.extractScript(result);".
			"\$(\"#".$id."_content\").html(jsAndHtml.html);".
			"\$(\"#".$id."_content\").append(jsAndHtml.js);".
		"});".
	"};".
	"\r\n"
,"load");
$this->setHtmlJsSourceOrAjax("\$(\"body\").append(\$(\"#".$id."\").detach());","load");
if($this->isAjax()){
	$this->setHtmlJsSourceOrAjax(
	"\$(\"#".$id." ._modal-close-button\").click(function(){XUI.Modal.deactivate();});"
	,"load");
};
$this->setHtmlJsSourceOrAjaxCsrfToken();
