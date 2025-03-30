<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$setup = &$this->cloud->getModule("xyo-mod-setup");
if ($setup) {

	// ---

	$setup->registerModule("xyo", null, "xyo-app-dashboard");
	$setup->registerModuleAcl("xyo-app-dashboard", "sidebar", null, "authenticated", 100, true);

	$setup->registerModule("xyo", null, "xyo-tpl-dashboard-administrator");
	$setup->registerModuleAcl("xyo-tpl-dashboard-administrator", "template", "administrator", null, 0, true);

	$setup->registerModule("xyo", null, "xyo-tpl-dashboard-administrator-2");
	$setup->registerModuleAcl("xyo-tpl-dashboard-administrator-2", "template", "administrator", null, 0, true);

	$setup->registerModule("xyo", null, "xyo-tpl-dashboard-administrator-3");
	$setup->registerModuleAcl("xyo-tpl-dashboard-administrator-3", "template", "administrator", null, 0, true);

	//
	$setup->selectMouleAclAsTemplate("xyo-tpl-dashboard-administrator-2", "administrator", null);
	//

	$setup->registerModule("xyo", null, "xyo-tpl-dashboard-public");
	$setup->registerModuleAcl("xyo-tpl-dashboard-public", "template", "public", null, 0, true);

	$setup->registerModule("xyo", null, "xyo-tpl-dashboard-public-2");
	$setup->registerModuleAcl("xyo-tpl-dashboard-public-2", "template", "public", null, 0, true);

	$setup->registerModule("xyo", null, "xyo-tpl-dashboard-public-3");
	$setup->registerModuleAcl("xyo-tpl-dashboard-public-3", "template", "public", null, 0, true);

	//
	$setup->selectMouleAclAsTemplate("xyo-tpl-dashboard-public-2", "public", null);
	//

	$setup->registerModule("xyo", null, "xyo-app-login");
	$setup->registerModuleAcl("xyo-app-login", "none", "administrator", "public", 0, true);

	$setup->registerModule("xyo", null, "xyo-app-control-panel");
	$setup->registerModuleAcl("xyo-app-control-panel", "sidebar", "administrator", "authenticated", 10000, true);

	$setup->registerModule("xyo", null, "xyo-app-logout");
	$setup->registerModuleAcl("xyo-app-logout", "control-panel", "administrator", "authenticated", 20000, true);
	$setup->registerModuleAcl("xyo-app-logout", "user", "administrator", "authenticated", 20000, true);

	$setup->registerModule("xyo", null, "xyo-app-install");
	$setup->registerModuleAcl("xyo-app-install", "control-panel", "administrator", "wheel", 1, true);

	$setup->registerModule("xyo", null, "xyo-app-about");
	$setup->registerModuleAcl("xyo-app-about", "control-panel", "administrator", "authenticated", 10000, true);

	$setup->registerModule("xyo", null, "xyo-mod-toolbar");
	$setup->registerModuleAcl("xyo-mod-toolbar","none",null,null,0,true);

	$setup->registerModule("xyo", null, "xyo-app-application");
	$setup->registerModuleAcl("xyo-app-application","none", null,null,0,true);

	$setup->registerModule("xyo", null, "xyo-app-table");
	$setup->registerModuleAcl("xyo-app-table","none", null, null,0,true);

	// ---

	$setup->registerModule("xyo", null, "xyo-app-user");
	$setup->registerModuleAcl("xyo-app-user","control-panel","administrator","administrator",100,true);

	$setup->registerModule("xyo", null, "xyo-app-user-x-user-group");
	$setup->registerModuleAcl("xyo-app-user-x-user-group","none","administrator","administrator",110,true);

	$setup->registerModule("xyo", null, "xyo-app-user-group");
	$setup->registerModuleAcl("xyo-app-user-group","control-panel","administrator","wheel",120,true);

	$setup->registerModule("xyo", null, "xyo-app-user-group-x-user-group");
	$setup->registerModuleAcl("xyo-app-user-group-x-user-group","none", "administrator","wheel",130,true);

	$setup->registerModule("xyo", null, "xyo-app-module");
	$setup->registerModuleAcl("xyo-app-module","control-panel","administrator","wheel",140,true);

	$setup->registerModule("xyo", null, "xyo-app-module-group");
	$setup->registerModuleAcl("xyo-app-module-group","control-panel","administrator","wheel",150,true);

	$setup->registerModule("xyo", null, "xyo-app-module-settings");
	$setup->registerModuleAcl("xyo-app-module-settings","none","administrator","wheel",160,true);

	$setup->registerModule("xyo", null, "xyo-app-language");
	$setup->registerModuleAcl("xyo-app-language","control-panel","administrator","wheel",170,true);

	$setup->registerModule("xyo", null, "xyo-app-datasource");
	$setup->registerModuleAcl("xyo-app-datasource","control-panel","administrator", "wheel",180,true);

	$setup->registerModule("xyo", null, "xyo-app-core");
	$setup->registerModuleAcl("xyo-app-core","control-panel","administrator", "wheel",190,true);

	$setup->registerModule("xyo", null, "xyo-app-acl-module");
	$setup->registerModuleAcl("xyo-app-acl-module","control-panel","administrator", "wheel",200,true);

	$setup->registerModule("xyo", null, "xyo-app-settings");
	$setup->registerModuleAcl("xyo-app-settings","control-panel","administrator","administrator",210,true);

	$setup->registerModule("xyo", null, "xyo-app-template");
	$setup->registerModuleAcl("xyo-app-template","control-panel","administrator","administrator",220,true);

	$setup->registerModule("xyo", null, "xyo-app-datasource-backup");
	$setup->registerModuleAcl("xyo-app-datasource-backup","none","administrator","wheel",230,true);

	$setup->registerModule("xyo", null, "xyo-app-user-profile");
	$setup->registerModuleAcl("xyo-app-user-profile", "control-panel","administrator", "authenticated", 18000, true);
	$setup->registerModuleAcl("xyo-app-user-profile", "user","administrator", "authenticated", 100, true);

	$setup->registerModule("xyo", null, "xyo-app-module-settings-x-user");
	$setup->registerModuleAcl("xyo-app-module-settings-x-user","none","administrator","authenticated",240,true);

	// local / customize

	$setup->includeConfigWithPattern("xyo-cloud-install");
};
