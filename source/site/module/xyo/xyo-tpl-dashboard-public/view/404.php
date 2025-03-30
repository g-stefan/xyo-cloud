<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

header("HTTP/1.0 404 Not Found");

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
		<?php 
		$this->ecssBegin();
		echo ".x404.--x-1{margin-top:64px;width:320px;}";
		echo ".x404.--x-2{float:left;margin-top:-2px;}";
		$this->ecssEnd();
		?>
	</head>
	<body<?php $this->eHtmlBodyClass(); ?>>
		<div class="flex flex-col items-center justify-center">
			<div class="xui-alert --danger x404 --x-1">
				<span class="lucide-info x404 --x-2"></span>
				404 Not found
			</div>
		</div>
		<?php $this->eHtmlScript(); ?>
	</body>
</html>
