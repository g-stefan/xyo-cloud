<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
<div class="xui application -has-toolbar<?php if($hasMessage&&(!$this->useNotify)){echo " -has-message";}; if($this->isEmbedded){echo " -embedded";}; ?>">
	<div class="xui app-toolbar <?php  if($this->isEmbedded){echo " -compact -wide";}; ?>" id="<?php echo $this->instanceV; ?>xui-app-toolbar">
	<?php if($this->isEmbedded){ ?>
		<style>
		.xui.application .xyo-app-application-info_embedded_icon {
			height:32px;
			padding: 6px;
			display: inline-block;
		}

		.xui.application .xyo-app-application-info_embedded_text {
			height:32px;
			padding-top: 6px;
			font-size: 16px;
			line-height: 24px;
			font-weight: normal;
			display: inline-block;
		}
			
		.xui.application .xui.app-toolbar.-important .xyo-app-application-info_embedded_text {
			display: none;
		}
		</style>
		<div class="xui _content_left" id="<?php echo $this->instanceV; ?>xui-app-toolbar_content_left">
			<div class="xui -fg-primary-2 -left xyo-app-application-info_embedded_icon"><?php echo $this->applicationIcon; ?></div>
			<div class="xui -fg-secondary-2 -left xyo-app-application-info_embedded_text"><?php echo $this->applicationTitle; ?></div>
			<?php if($this->hasLeftToolbar){ $this->generateView("toolbar-left"); }; ?>
		</div>
		<div class="xui _content_right" id="<?php echo $this->instanceV; ?>xui-app-toolbar_content_right">
	<?php } else if($this->hasLeftToolbar){ ?>
		<div class="xui _content_left" id="<?php echo $this->instanceV; ?>xui-app-toolbar_content_left">
			<?php $this->generateView("toolbar-left"); ?>
		</div>
		<div class="xui _content_right" id="<?php echo $this->instanceV; ?>xui-app-toolbar_content_right">
	<?php } else { ?>
		<div class="xui _content" id="<?php echo $this->instanceV; ?>xui-app-toolbar_content">
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
	<div class="xui _line"></div>
<?php }; ?>
	<div class="xui _content -overlay-scrollbars">
		<?php $this->generateCurrentView(); ?>
	</div>
</div>

<div class="xui separator" id="<?php echo $this->instanceV; ?>xui-application-responsive"></div>

<?php

if($this->isEmbedded || $this->hasLeftToolbar){
	$this->setHtmlJsSourceOrAjax("XUI.App.Toolbar.linkResponsiveLeftRight(\"".$this->instanceV."xui-application-responsive\",\"".$this->instanceV."xui-app-toolbar\",\"".$this->instanceV."xui-app-toolbar_content_left\",\"".$this->instanceV."xui-app-toolbar_content_right\");","load");
} else {
	$this->setHtmlJsSourceOrAjax("XUI.App.Toolbar.linkResponsive(\"".$this->instanceV."xui-application-responsive\",\"".$this->instanceV."xui-app-toolbar\",\"".$this->instanceV."xui-app-toolbar_content\");","load");
}

if($this->hasApplicationMenu) {
	$xuiDashboard=&$this->getModule("xui-dashboard");
	$applicationMenu=&$this->getModule("xyo-mod-xui-menu");	
	$applicationMenu->initModule($this->name);
	echo "<ul class=\"xui menu -popup\" id=\"popup-menu-application\">";
		$xuiDashboard->generateApplicationMenu($applicationMenu->getMenu());
	echo "</ul>";
};
