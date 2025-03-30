<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->isNew = true;
$this->processModel("set-ds");
$this->processModel("form-default");

if ($this->isError()) {
	$this->doRedirect("form-error");
	return;
};

$this->setParameter("toolbar", "toolbar/form-new");
$this->processModel("form-new");
$this->setView("form-new");
