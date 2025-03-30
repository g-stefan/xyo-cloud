<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->requestUriRedirect("/admin/dashboard",array("run"=>"xyo-app-dashboard"),"/admin/run/xyo-app-dashboard");
$this->requestUriRedirect("/admin/install",array("run"=>"xyo-app-install"),"/admin/run/xyo-app-install");
$this->requestUriRedirect("/admin/users",array("run"=>"xyo-app-user"),"/admin/run/xyo-app-user");
$this->requestUriRedirect("/admin/groups-of-users",array("run"=>"xyo-app-user-group"),"/admin/run/xyo-app-user-group");
$this->requestUriRedirect("/admin/module",array("run"=>"xyo-app-module"),"/admin/run/xyo-app-module");
$this->requestUriRedirect("/admin/module-groups",array("run"=>"xyo-app-module-group"),"/admin/run/xyo-app-module-group");
$this->requestUriRedirect("/admin/language",array("run"=>"xyo-app-language"),"/admin/run/xyo-app-language");
$this->requestUriRedirect("/admin/datasource",array("run"=>"xyo-app-datasource"),"/admin/run/xyo-app-datasource");
$this->requestUriRedirect("/admin/core",array("run"=>"xyo-app-core"),"/admin/run/xyo-app-core");
$this->requestUriRedirect("/admin/acl-module",array("run"=>"xyo-app-acl-module"),"/admin/run/xyo-app-acl-module");
$this->requestUriRedirect("/admin/settings",array("run"=>"xyo-app-settings"),"/admin/run/xyo-app-settings");
$this->requestUriRedirect("/admin/template",array("run"=>"xyo-app-template"),"/admin/run/xyo-app-template");
$this->requestUriRedirect("/admin/about",array("run"=>"xyo-app-about"),"/admin/run/xyo-app-about");
$this->requestUriRedirect("/admin/profile",array("run"=>"xyo-app-user-profile"),"/admin/run/xyo-app-user-profile");
$this->requestUriRedirect("/admin/logout",array("run"=>"xyo-app-logout"),"/admin/run/xyo-app-logout");

if(defined("XYO_CLOUD_ROUTER_DEFAULT") && defined("XYO_CLOUD_ADMINISTRATOR")) {

	$this->requestUriRedirect("/dashboard",array("run"=>"xyo-app-dashboard"),"/run/xyo-app-dashboard");
	$this->requestUriRedirect("/install",array("run"=>"xyo-app-install"),"/run/xyo-app-install");
	$this->requestUriRedirect("/users",array("run"=>"xyo-app-user"),"/run/xyo-app-user");
	$this->requestUriRedirect("/groups-of-users",array("run"=>"xyo-app-user-group"),"/run/xyo-app-user-group");
	$this->requestUriRedirect("/module",array("run"=>"xyo-app-module"),"/run/xyo-app-module");
	$this->requestUriRedirect("/module-groups",array("run"=>"xyo-app-module-group"),"/run/xyo-app-module-group");
	$this->requestUriRedirect("/language",array("run"=>"xyo-app-language"),"/run/xyo-app-language");
	$this->requestUriRedirect("/datasource",array("run"=>"xyo-app-datasource"),"/run/xyo-app-datasource");
	$this->requestUriRedirect("/core",array("run"=>"xyo-app-core"),"/run/xyo-app-core");
	$this->requestUriRedirect("/acl-module",array("run"=>"xyo-app-acl-module"),"/run/xyo-app-acl-module");
	$this->requestUriRedirect("/settings",array("run"=>"xyo-app-settings"),"/run/xyo-app-settings");
	$this->requestUriRedirect("/template",array("run"=>"xyo-app-template"),"/run/xyo-app-template");
	$this->requestUriRedirect("/about",array("run"=>"xyo-app-about"),"/run/xyo-app-about");
	$this->requestUriRedirect("/profile",array("run"=>"xyo-app-user-profile"),"/run/xyo-app-user-profile");
	$this->requestUriRedirect("/logout",array("run"=>"xyo-app-logout"),"/run/xyo-app-logout");

};

