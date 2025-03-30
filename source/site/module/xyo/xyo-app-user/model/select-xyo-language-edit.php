<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$language = array();
$language["*"] = $this->getFromLanguage("select.xyo_language_none");
$dsLanguage = &$this->getDataSource("db.table.xyo_language");
if ($dsLanguage) {
	$dsLanguage->clear();
	$dsLanguage->setOrder("description",1);
	for ($dsLanguage->load(); $dsLanguage->isValid(); $dsLanguage->loadNext()) {
		$language[$dsLanguage->id] = $dsLanguage->description;
	};
};

$this->setParameter("select.xyo_language_id",$language);
