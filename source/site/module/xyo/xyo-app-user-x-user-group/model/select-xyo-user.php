<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$user = array();
$user["*"] = $this->getFromLanguage("select.xyo_user_any");
$dsUser = &$this->getDataSource("db.table.xyo_user");
if ($dsUser) {
	$dsUser->clear();
	$dsUser->setOrder("name",1);
	for ($dsUser->load(); $dsUser->isValid(); $dsUser->loadNext()) {
		$user[$dsUser->id] = $dsUser->name;
	};
};

$this->setParameter("select.xyo_user_id",$user);
