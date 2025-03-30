<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->isNew = true;
$this->processModel("set-ds");

if (!$this->isError()) {
	$this->clearElementError();
	$this->processModel("form-new-save");
};

if ($this->isError()) {
	$this->setParameter("toolbar", "toolbar/table-new");
	$this->processModel("form-new");
	$this->setView("form-new");
	return;
};

$this->doRedirect("form-edit");
