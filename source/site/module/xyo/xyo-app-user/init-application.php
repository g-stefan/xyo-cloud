<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"lucide-user\"></i>");
$this->setApplicationDataSource("db.query.xyo_user");
$this->setPrimaryKey("id");

$this->hasLeftToolbar = true;
$this->hasApplicationMenu = true;
$userSettings = &$this->getModule("xyo-mod-ds-user-settings");
if(1*$userSettings->getModuleSetting($this->name,"inline_form",0)) {
	$this->setInlineForm(true);
};

$this->requireComponent(array(
	"xui.form-action-begin",
	"xui.form-action-end",
	"xui.panel-begin",
	"xui.panel-end",
	"xui.form-email",
	"xui.form-password",
	"xui.form-username",	
	"xui.form-text",	
	"xui.form-textarea",
	"xui.form-select",
	"xui.form-image",
	"xui.form-switch",
	"xui.form-action-apply",
	"xui.form-text-icon-right",

	"xui.box-1x2-begin",
	"xui.box-1x2-separator",
	"xui.box-1x2-end",

	"xui.box-2x1-begin",
	"xui.box-2x1-end"
));

// ---

$userId=$this->getPrimaryKeyValueOne($this->getRequestInstance("primary_key_value"));
if($userId){
	$dsUser = &$this->getDataSource("db.table.xyo_user");
	if ($dsUser) {
		$dsUser->clear();
		$dsUser->id = $userId;
		if ($dsUser->load(0, 1)) {
			$this->setApplicationTitle($this->getFromLanguage("application.title") . " - " . $dsUser->name);
		};
	};
};

// --- 

$this->setHtmlCss($this->site."lib/xyo/xyo-app-user-form.css");
