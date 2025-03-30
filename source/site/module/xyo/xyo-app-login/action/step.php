<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setView("default");
$this->clearElementError();

$username = $this->getElementValueString("username");
if (strlen($username) == 0) {
	$this->setElementErrorFromLanguage("username", "is_empty");
};

$password = $this->getElementValueString("password");
if (strlen($password) == 0) {
	$this->setElementErrorFromLanguage("password", "is_empty");
};

if (!$this->isElementError()) {
	if (!$this->user->isAuthorized()) {
		$this->setError("error.invalid_login");
	};
};
