<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$hasMessage=false;
if($this->isAlert()){
	$hasMessage=true;
};
if($this->isError()){
	$hasMessage=true;
	$msgLang = "error.unknown";
	$msg = $this->getError();
	if ($msg) {
		if (is_array($msg)) {
			reset($msg);
			$msgLang = key($msg);
		}else{
			$msgLang = $msg;
		};
	};
	if($msgLang=="element"){
		$hasMessage=false;
	};
};

?>
<div class="xui-application-main --has-toolbar<?php if($hasMessage&&(!$this->useNotify)){echo " --has-message";}; if($this->isEmbedded){echo " --embedded";}; ?>">
	<div class="xui-application-toolbar <?php  if($this->isEmbedded){echo " --compact --wide";}; ?>" id="<?php echo $this->instanceV; ?>xui-application-toolbar">
	<?php if($this->isEmbedded){ ?>
		<?php $this->ecssBegin(); ?>
		.xui-application-main .xyo-app-application-info_embedded_icon {
			height:32px;
			padding: 6px;
			display: inline-block;
		}

		.xui-application-main .xyo-app-application-info_embedded_text {
			height:32px;
			padding-top: 6px;
			font-size: 16px;
			line-height: 24px;
			font-weight: normal;
			display: inline-block;
		}
			
		.xui-application-main .xui-application-toolbar.--important .xyo-app-application-info_embedded_text {
			display: none;
		}
		<?php $this->ecssEnd(); ?>
		<div class="xui-application-toolbar_content-left" id="<?php echo $this->instanceV; ?>xui-application-toolbar_content-left">
			<div class="text-xui-primary-500 float-left xyo-app-application-info_embedded_icon"><?php echo $this->applicationIcon; ?></div>
			<div class="text-xui-secondary-500 float-left xyo-app-application-info_embedded_text"><?php echo $this->applicationTitle; ?></div>
			<?php if($this->hasLeftToolbar){ $this->generateView("toolbar-left"); }; ?>
		</div>
		<div class="xui-application-toolbar_content-right" id="<?php echo $this->instanceV; ?>xui-application-toolbar_content-right">
	<?php } else if($this->hasLeftToolbar){ ?>
		<div class="xui-application-toolbar_content-left" id="<?php echo $this->instanceV; ?>xui-application-toolbar_content-left">
			<?php $this->generateView("toolbar-left"); ?>
		</div>
		<div class="xui-application-toolbar_content-right" id="<?php echo $this->instanceV; ?>xui-application-toolbar_content-right">
	<?php } else { ?>
		<div class="xui-application-toolbar_content" id="<?php echo $this->instanceV; ?>xui-application-toolbar_content">
	<?php }; $this->generateView("toolbar"); ?>
		</div>
	</div>
<?php
	if($hasMessage&&(!$this->useNotify)){
		if ($this->isError()) {
			$this->generateView("message/error");
		} else
		if ($this->isAlert()) {
    			$this->generateView("message/alert");
		};
	};
?>
<?php if(!$this->isEmbedded){ ?>
	<div class="xui-application-main_line"></div>
<?php }; ?>
	<div class="xui-application-main_content xui-overlay-scrollbars">
		<?php $this->generateCurrentView(); ?>
	</div>
</div>

<div class="clear-both" id="<?php echo $this->instanceV; ?>xui-application-main-responsive"></div>

<?php

if($this->isEmbedded || $this->hasLeftToolbar){
	$this->setHtmlJsSourceOrAjax("XUI.App.Toolbar.linkResponsiveLeftRight(\"".$this->instanceV."xui-application-main-responsive\",\"".$this->instanceV."xui-application-toolbar\",\"".$this->instanceV."xui-application-toolbar_content-left\",\"".$this->instanceV."xui-application-toolbar_content-right\");","load");
} else {
	$this->setHtmlJsSourceOrAjax("XUI.App.Toolbar.linkResponsive(\"".$this->instanceV."xui-application-main-responsive\",\"".$this->instanceV."xui-application-toolbar\",\"".$this->instanceV."xui-application-toolbar_content\");","load");
}

if($this->hasApplicationMenu) {
	$xuiDashboard=&$this->getModule("xui-dashboard");
	$applicationMenu=&$this->getModule("xyo-mod-xui-menu");	
	$applicationMenu->initModule($this->name);
	echo "<ul class=\"xui-menu --popup\" id=\"xui-popup-menu-application\">";
		$xuiDashboard->generateApplicationMenu($applicationMenu->getMenu());
	echo "</ul>";
};
