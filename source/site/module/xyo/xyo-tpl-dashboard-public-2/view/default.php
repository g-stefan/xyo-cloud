<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$dasboardType=explode("-",$this->getRequest("xui-dashboard","normal-open"));
$dasboardType=" -".$dasboardType[0]." -".$dasboardType[1];

$app=&$this->getModule($this->getApplication());
$title="";
if($app){
	if ($app instanceof xyo_mod_Application) {
		$title=$app->getApplicationTitle();
	}else
	if ($app instanceof xyo_Module) {
		$app->loadLanguage();
		$title=$app->getFromLanguage("application.title","");
	};
};

$userName="John Doe";
$userImage="";
$userDescription="User";
//
$modUser=&$this->getModule("xyo-mod-ds-user");
$dsUser=&$this->getDataSource("db.table.xyo_user");
$dsUser->clear();
$dsUser->id=$modUser->info->id;
if($dsUser->load(0,1)){
	$userImage=$dsUser->picture;
	$userName=$modUser->info->name;
	$userDescription=$dsUser->description;
	if(strlen($userDescription)==0){
		$userDescription="User";
	};
};
//
$modImage=&$this->getModule("xui-form-image");

$sidebar=&$this->getModule("xyo-mod-xui-sidebar");
$sidebar->initGroup("sidebar");

$userMenu=&$this->getModule("xyo-mod-xui-user");
$userMenu->initGroup("user");

$xuiDashboard=&$this->getModule("xui-dashboard");

?><!DOCTYPE html>
<html<?php $this->eHtmlLanguage(); $this->eHtmlClass();?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php $this->eHtmlTitle(); ?>
		<?php $this->eHtmlDescription(); ?>
		<?php $this->eHtmlIcon(); ?>
		<?php $this->eHtmlCss(); ?>
		<style>
			.xui.app-user > .xui._content > .xui._image > .xui._image_img {
				<?php $modImage->eImageCss($userImage); ?>
			}
			#navigation-drawer-content > .os-padding {
				z-index: auto;
			}
		</style>
	</head>
	<body<?php $this->eHtmlBodyClass(); ?>>
		<div class="xui dashboard -main<?php echo $dasboardType; ?>">
			<div class="xui app-header">
				<div class="xui app-brand">
					<div class="xui _content">
						<div class="xui _logo" style="background-image:url('<?php echo $this->site."lib/xyo/xyo-32.png"; ?>'"></div>
						<div class="xui _name -fg-science-blue-3">Cloud</div>
						<div class="xui _mark"></div>
					</div>
				</div>
				<div class="xui app-bar">
					<div class="xui button -icon -transparent -left -effect-ripple" onclick="XUI.Dashboard.toggleAction();">
						<i class="material-icons">menu</i>
					</div>
					<div class="xui text -size-h24x40 -left" id="xyo-application-title">
						<?php echo $title; ?>
					</div>
					<div class="xui -right">
						<?php $this->runGroup("status"); ?>
					</div>	
				</div>
				<div class="xui app-user-info">
					<div class="xui app-user">
						<div class="xui _content">
							<div class="xui _background_img"></div>
							<div class="xui _background"></div>
							<div class="xui _image -elevation-2">
								<div class="xui _image_img"></div>
							</div>
							<div class="xui _info">								
								<div class="xui _name"><?php echo $userName; ?></div>
								<div class="xui _position"><?php echo $userDescription; ?></div>
							</div>
						</div>
					</div>
					<?php if($userMenu->hasMenu()) { ?>
						<div class="xui button -icon -size-x32 -circle -transparent -effect-ripple" id="popup-menu-user-action">
							<i class="material-icons">expand_more</i>
						</div>
						<ul class="xui menu -popup" id="popup-menu-user">
							<?php $xuiDashboard->generateUserMenu($userMenu->getMenu()); ?>
						</ul>
					<?php }; ?>
				</div>
			</div>
			<div class="xui navigation-drawer">
				<div class="xui _content" id="navigation-drawer-content">
					<ul class="xui menu">
						<?php $xuiDashboard->generateNavigationDrawerMenu($sidebar->getMenu()); ?>
					</ul>
				</div>
			</div>
			<div class="xui content">
				<?php $this->generateApplicationView(); ?>
			</div>
			<div class="xui content-cover"></div>
		</div>
		<?php $this->eHtmlScript(); ?>
	</body>
</html>
