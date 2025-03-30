<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$dasboardType=explode("-",$this->getRequest("xui-dashboard","normal-open"));
$dasboardType=" --".$dasboardType[0]." --".$dasboardType[1];

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
	$userImageCss = "background-color: transparent;";
	$userImageCss .= "mask-image: none;";
	$userImageCss .= "background-image:url(\"".$userImageThumbnail."\");";
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
			.xui-application-user > .xui-application-user_content > .xui-application-user_image > .xui-application-user_image_img {
				<?php echo $userImageCss; ?>
			}
			#xui-navigation-drawer_content > .os-padding {
				z-index: auto;
			}
			.xui-application-brand > .xui-application-brand_content > .xui-application-brand_logo {
				background-color: transparent;
				mask-image: none;
				background-image: url(<?php echo $settings["brand_logo"] ?>);
			}
		<?php $this->ecssEnd(); ?>
	</head>
	<body<?php $this->eHtmlBodyClass(); ?>>
		<div class="xui-dashboard --theme-3 --main<?php echo $dasboardType; ?>">
			<div class="xui-application-header">
				<div class="xui-application-bar">
					<?php $uid=$this->getUID();?>
					<div  id="<?php echo $uid; ?>" class="xui-button --icon --transparent float-left xui-effect-ripple --toolbar">
						<i class="lucide-menu"></i>
					</div>
					<?php
					$this->ejsBegin();
					echo "document.getElementById(\"".$uid."\").onclick=function(){XUI.Dashboard.toggleAction();};";
					$this->ejsEnd();
					?>
					<div class="xui-application-bar_text" id="xyo-application-title">
						<?php echo $title; ?>
					</div>
					<div class="float-right">
						<?php $this->runGroup("status"); ?>
						<?php $this->runModule("xyo-mod-app-search"); ?>
					</div>	
				</div>
				<div class="xui-application-user-info">
					<div class="xui-application-user">
						<div class="xui-application-user_content">							
							<div class="xui-application-user_image">
								<div class="xui-application-user_image_img"></div>
							</div>
							<div class="xui-application-user_info">								
								<div class="xui-application-user_name"><?php echo $userName; ?></div>
								<div class="xui-application-user_position"><?php echo $userDescription; ?></div>
							</div>
						</div>
					</div>
					<?php if($userMenu->hasMenu()) { ?>
						<div class="xui-button --icon --size-x32 --circle --transparent xui-effect-ripple --toolbar" id="xui-popup-menu-user_action">
							<i class="lucide-chevron-down"></i>
						</div>
						<ul class="xui-menu --popup" id="xui-popup-menu-user">
							<?php $xuiDashboard->generateUserMenu($userMenu->getMenu()); ?>
						</ul>
					<?php }; ?>
				</div>
			</div>
			<div class="xui-navigation-drawer">
				<div class="xui-navigation-drawer_content" id="xui-navigation-drawer_content">
					<div class="xui-application-brand">
						<div class="xui-application-brand_content">
							<div class="xui-application-brand_logo"></div>
							<div class="xui-application-brand_name text-xui-science-blue-3-500"><?php echo $settings["brand_name"] ?></div>
							<div class="xui-application-brand_mark"><?php echo $settings["brand_mark"] ?></div>
						</div>
					</div>
					<ul class="xui-menu">
						<?php $xuiDashboard->generateNavigationDrawerMenu($sidebar->getMenu()); ?>
					</ul>
				</div>
			</div>
			<div class="xui-content">
				<?php $this->generateApplicationView(); ?>
			</div>
			<div class="xui-content-cover"></div>
		</div>
		<?php $this->eHtmlScript(); ?>
	</body>
</html>
