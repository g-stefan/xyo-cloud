<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"lucide-users\"></i>");
$this->setApplicationDataSource("db.query.xyo_user_x_user_group");
$this->setPrimaryKey("id");

$this->setDialogNew(true);
$this->setDialogEdit(true);

$this->allowEmbedding();

$this->requireComponent(array(
	"xui.form-select",
	"xui.form-switch",
	"xui.panel-begin",
	"xui.panel-end",
	"xui.box-1x1-begin",
	"xui.box-1x1-end"
));

$this->xyo_user_id = 1 * $this->getParameterRequestInstance("xyo_user_id", 0);
if ($this->xyo_user_id) {
	$this->setKeepRequestInstance("xyo_user_id", $this->xyo_user_id);

	$dsUser = &$this->getDataSource("db.table.xyo_user");
	if ($dsUser) {
		$dsUser->clear();
		$dsUser->id = $this->xyo_user_id;
		if ($dsUser->load(0, 1)) {
			$this->setApplicationTitle($this->getFromLanguage("application.title") . " - " . $dsUser->name);
		};
	};
};

if($this->isEmbedded){
	$this->hasFilterToolbar(true);
	$this->setApplicationTitle($this->getFromLanguage("application.title_embedded"));
	$this->setRequestInstance("count", $this->getRequestInstance("count","10"));
};
