<?php
// Copyright (c) 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2024 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

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
	if(is_null($userDescription)||(strlen($userDescription)==0)){
		$userDescription="User";
	};
};
//
$modThumbnail=&$this->getModule("xyo-mod-thumbnail");

$sidebar=&$this->getModule("xyo-mod-xui-sidebar");
$sidebar->initGroup("sidebar");

$userMenu=&$this->getModule("xyo-mod-xui-user");
$userMenu->initGroup("user");

$xuiDashboard=&$this->getModule("xui-dashboard");

$modSettings = &$this->getModule("xyo-mod-ds-settings");
$settings = array(
	"brand_logo" => "",
	"brand_name" => "Cloud",
	"brand_mark" => ""
);
$modSettings->getSettingsList($settings);
$settings["brand_logo"] = $modThumbnail->xuiMakeThumbnailSite($settings["brand_logo"],32,32);
if(strlen($settings["brand_logo"])==0) {
	$settings["brand_logo"]=$this->site."lib/xyo/xyo-32.png";
};

$userImageCss = "";
$userImageThumbnail = $modThumbnail->xuiMakeThumbnailSite($userImage,128,128);
if(strlen($userImageThumbnail)>0) {
	$userImageCss = "background-image:url(\"".$userImageThumbnail."\");";
};

?><!DOCTYPE html>
<html<?php $this->eHtmlLanguage(); $this->eHtmlClass();?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php $this->eHtmlTitle(); ?>
		<?php $this->eHtmlDescription(); ?>
		<?php $this->eHtmlIcon(); ?>
		<?php $this->eHtmlStyle(); ?>
		<?php $this->ecssBegin(); ?>
			.xui.app-user > .xui._content > .xui._image > .xui._image_img {
				<?php echo $userImageCss; ?>
			}
			#navigation-drawer-content > .os-padding {
				z-index: auto;
			}
			.xui.app-brand > .xui._content > .xui._logo {
				background-image: url(<?php echo $settings["brand_logo"] ?>);
			}
		<?php $this->ecssEnd(); ?>
	</head>
	<body<?php $this->eHtmlBodyClass(); ?>>
		<div class="xui dashboard -main<?php echo $dasboardType; ?>">
			<div class="xui app-header">
				<div class="xui app-brand">
					<div class="xui _content">
						<div class="xui _logo"></div>
						<div class="xui _name -fg-science-blue-3"><?php echo $settings["brand_name"] ?></div>
						<div class="xui _mark"><?php echo $settings["brand_mark"] ?></div>
					</div>
				</div>
				<div class="xui app-bar">
				<?php $uid=$this->getUID();?>
					<div  id="<?php echo $uid; ?>" class="xui button -icon -transparent -left -effect-ripple -toolbar">
						<i class="lucide-menu"></i>
					</div>
					<?php
					$this->ejsBegin();
					echo "document.getElementById(\"".$uid."\").onclick=function(){XUI.Dashboard.toggleAction();};";
					$this->ejsEnd();
					?>
					<div class="xui text -size-h24x40 -left" id="xyo-application-title">
						<?php echo $title; ?>
					</div>
					<div class="xui -right">
						<?php $this->runGroup("status"); ?>
						<?php $this->runModule("xyo-mod-app-search"); ?>
					</div>	
				</div>
				<div class="xui app-user-info">
					<div class="xui app-user">
						<div class="xui _content">							
							<div class="xui _image">
								<div class="xui _image_img"></div>
							</div>
							<div class="xui _info">								
								<div class="xui _name"><?php echo $userName; ?></div>
								<div class="xui _position"><?php echo $userDescription; ?></div>
							</div>
						</div>
					</div>
					<div class="xui button -icon -size-x32 -circle -transparent -effect-ripple -toolbar" id="popup-menu-user-action">
						<i class="lucide-chevron-down"></i>
					</div>
					<ul class="xui menu -popup" id="popup-menu-user">
						<?php $xuiDashboard->generateUserMenu($userMenu->getMenu()); ?>
					</ul>
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
