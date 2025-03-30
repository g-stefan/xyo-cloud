<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

?><!DOCTYPE html>
<html<?php $this->eHtmlLanguage(); $this->eHtmlClass();?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<?php $this->eHtmlTitle(); ?>
		<?php $this->eHtmlDescription(); ?>
		<?php $this->eHtmlIcon(); ?>
		<?php $this->eHtmlStyle(); ?>
	</head>
	<body<?php $this->eHtmlBodyClass(); ?>>
<?php
$uid=$this->getUID();
$this->ecssBegin();
echo ".".$uid."-img {width:32px;height:32px;border: 0px;vertical-align: middle;display:inline-block;}";
echo ".".$uid."-1 {font-size:22px;font-weight:bold;vertical-align: middle;}";
echo ".".$uid."-2 {font-size:11px;padding-top:16px;padding-bottom:0px;margin-bottom:0px;overflow:hidden;height:32px;box-sizing: border-box;}";
echo ".".$uid."-3 {color:#000000;font-size:11px;white-space: nowrap;}";
echo ".".$uid."-4 {height:96px;}";
echo ".".$uid."-5 {text-decoration:none;}";
$this->ecssEnd();

?>

		<div class="xyo install-application-top-space"></div>

		<?php
		$this->generateComponent("xui.box-x-900-begin");
		$this->generateComponent("xui.panel2-begin",array("css-class"=>"shadow-md"));
		?>
	
		<img src="<?php echo $this->site; ?>lib/xyo/xyo-32.png" class="<?php echo $uid."-img"; ?>" alt="XYO" ></img>
		<span class="text-xui-science-blue-3-500 <?php echo $uid."-1"; ?>" >&#160;CLOUD&#160;</span>
		<span class="float-right text-xui-science-blue-3-500 <?php echo $uid."-2"; ?>">
			<?php echo $this->cloud->get("xyo_cloud_version"); ?>
		</span>

	        <?php

		$this->generateComponent("xui.panel2-content");
		$this->generateApplicationView();
		$this->generateComponent("xui.panel2-footer");

		?>
		<span class="float-right <?php echo $uid."-3"; ?>"><?php echo $this->getFromLanguage("copyright"); ?> &copy; 2009-2023 <a href="http://www.xyo.ro" class="<?php echo $uid."-5"; ?>""><span class="text-xui-science-blue-3-500">Grigore Stefan</span></a></span>

		<?php

		$this->generateComponent("xui.panel2-end");
		$this->generateComponent("xui.box-x-900-end");

		?>

		<div class="<?php echo $uid."-4"; ?>"></div>

		<?php $this->eHtmlScript(); ?>
	</body>
</html>