<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
