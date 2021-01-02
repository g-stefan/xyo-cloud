<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
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
<div class="xui application -has-toolbar<?php if($hasMessage&&(!$this->useNotify)){echo " -has-message";}; ?>">
	<div class="xui app-toolbar <?php  if($this->isEmbedded){echo " -compact -wide";}; ?>" id="<?php echo $this->instanceV; ?>xui-app-toolbar">
		<div class="xui _content" <?php  if(!$this->isEmbedded){echo "id=\"".$this->instanceV."xui-app-toolbar_content\"";};?>>
<?php if($this->isEmbedded){ ?>
			<div class="xui grid">
				<div class="xui grid -row">
					<div class="xui grid -col -x0">
						<div class="xui -fg-primary-2 -left" style="height:32px;padding: 6px;display: inline-block;"><?php echo $this->applicationIcon; ?></div>
						<div class="xui -fg-secondary-2 -left" style="height:32px;padding-top: 6px;font-size: 16px;line-height: 24px;font-weight: normal;display: inline-block;"><?php echo $this->applicationTitle; ?></div>
					</div>
					<div class="xui grid -col -x0" id="<?php echo $this->instanceV; ?>xui-app-toolbar_content">
<?php }; 

$this->generateView("toolbar"); 

if($this->isEmbedded){ ?>
					</div>
				</div>
			</div>
<?php }; ?>
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

$this->setHtmlJsSourceOrAjax("XUI.App.Toolbar.linkResponsive(\"".$this->instanceV."xui-application-responsive\",\"".$this->instanceV."xui-app-toolbar\",\"".$this->instanceV."xui-app-toolbar_content\");","load");
