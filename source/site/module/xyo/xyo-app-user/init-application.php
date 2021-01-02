<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"material-icons\">person</i>");
$this->setApplicationDataSource("db.query.xyo_user");
$this->setPrimaryKey("id");

//$this->setInlineForm(true);

$this->requireComponent(array(
	"xui.form-action-begin",
	"xui.form-action-end",
	"xui.panel-begin",
	"xui.panel-end",
	"xui.form-email",
	"xui.form-password",
	"xui.form-username",
	"xui.form-password-required",
	"xui.form-username-required",
	"xui.form-text",
	"xui.form-text-required",
	"xui.form-textarea",
	"xui.form-select",
	"xui.form-image",
	"xui.form-switch",
	"xui.form-action-apply",

	"xui.box-1x2-begin",
	"xui.box-1x2-separator",
	"xui.box-1x2-end",

	"xui.box-2x1-begin",
	"xui.box-2x1-end"
));

// ---

$userId=1*$this->getPrimaryKeyValueOne($this->getRequestInstance("primary_key_value"));
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

