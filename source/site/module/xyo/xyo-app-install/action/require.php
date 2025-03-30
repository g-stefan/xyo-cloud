<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$mode = $this->getRequest("mode");
if (!$mode) {
	$this->doRedirect("package");
	return;
};
$package = $this->getRequest("package");
if ($mode === "single") {
	if ($package === "*") {
		$this->doRedirect("package");
		return;
	};
};
if ($mode === "all") {
	$modSetup = &$this->getModule("xyo-mod-setup");
	if ($modSetup) {
		$path = "package/";
		$list = $modSetup->getPackageList2($path);
		if (!count($list)) {
			$this->doRedirect("package");
			return;
        	};
	};
};

$this->setView("require");
