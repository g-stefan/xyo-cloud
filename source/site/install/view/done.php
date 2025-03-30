<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");


$this->generateComponent("xui.form-action-begin",array("action"=>$this->getFormActionRouteModule("index.php","xyo-app-dashboard")));

echo "<div class=\"float-right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"disabled",
	"try"=>"disabled",
	"next"=>"success"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";

$this->generateViewLanguage("msg-done");

if ($this->isError()) {
	$this->generateView("msg-error");
};

// get login salt
$this->cloud->includeConfig("config.website");
$this->cloud->setCSRFMitigationProvider("xyo-mod-ds-user");

$administrator = $this->getRequest("administrator_username");
if ($administrator) {
	$this->accessControlList->reloadDataSource();
	$this->user->reloadDataSource();
	$authorization = $this->user->getAuthorizationRequestDirect($administrator);
	if ($authorization) {
		$this->csrfReset();
		$this->eFormCsrfToken();
		$this->eFormBuildRequest($authorization);
	};
};

$this->generateComponent("xui.form-action-end");

echo "<div class=\"clear-both h-4\"></div>";