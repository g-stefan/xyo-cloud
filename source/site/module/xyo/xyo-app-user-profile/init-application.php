<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"lucide-user\"></i>");
$this->setApplicationDataSource("db.table.xyo_user");
$this->setPrimaryKey("id");

$this->setDefaultAction($this->getRequest("action", "form-edit"));

$this->requireComponent(array(
	"xui.form-select",
	"xui.form-text",	
	"xui.form-textarea",
	"xui.form-username",
	"xui.form-password",	
	"xui.form-image",
	"xui.form-email",
	"xui.form-action-apply",
	"xui.form-text-icon-right",

	"xui.panel-begin",
	"xui.panel-end",
	"xui.box-1x2-begin",
	"xui.box-1x2-separator",
	"xui.box-1x2-end"
));

// ---
if($this->user->info->id){
	$dsUser = &$this->getDataSource("db.table.xyo_user");
	if ($dsUser) {
		$dsUser->clear();
		$dsUser->id = $this->user->info->id;
		if ($dsUser->load(0, 1)) {
			$this->setApplicationTitle($this->getFromLanguage("application.title") . " - " . $dsUser->name);
		};
	};
};

// --- 

$this->setHtmlCss($this->site."lib/xyo/xyo-app-user-form.css");

