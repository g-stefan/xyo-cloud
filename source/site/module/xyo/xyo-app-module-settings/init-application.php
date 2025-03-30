<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setApplicationIcon("<i class=\"lucide-list\"></i>");
$this->setApplicationDataSource("db.table.xyo_module_settings");

$this->setDefaultAction($this->getRequest("action", "form-edit"));

$xyo_acl_module_id=1 * $this->getParameterRequest("xyo_acl_module_id", 0);
$this->xyo_module_id = 1 * $this->getParameterRequest("xyo_module_id", 0);
if ($this->xyo_module_id==0) {
	if ($xyo_acl_module_id) {
		$dsAclModule = &$this->getDataSource("db.table.xyo_acl_module");
		if($dsAclModule){
			$dsAclModule->clear();
			$dsAclModule->id=$xyo_acl_module_id;
			if($dsAclModule->load(0,1)){
				$this->xyo_module_id=$dsAclModule->xyo_module_id;
			};
		};
	};
};

if ($this->xyo_module_id) {
	$this->setKeepRequest("xyo_module_id", $this->xyo_module_id);

	$dsModule = &$this->getDataSource("db.table.xyo_module");
	if ($dsModule) {
		$dsModule->clear();
		$dsModule->id = $this->xyo_module_id;
		if ($dsModule->load(0, 1)) {

			$moduleNameFound = false;
			$moduleName = $dsModule->name;
			$path=$this->getModulePath($dsModule->name);
			if($path) {
				if(file_exists($path."sys/info.json")) {
					$json=json_decode(file_get_contents($path."sys/info.json"));
					if($json) {

						if(property_exists($json,"theme")) {
							if(property_exists($json->theme,"name")) {
								$moduleName=$json->theme->name;
								$moduleNameFound = true;
							};
						};

						if(property_exists($json,"module")) {
							if(property_exists($json->module,"name")) {
								$moduleName=$json->module->name;
								$moduleNameFound = true;
							};
						};

					};
				};
			};

			if(!$moduleNameFound) {
				$mod = &$this->getModule($dsModule->name);
				if ($mod instanceof xyo_mod_Application) {
					$moduleName = $mod->getApplicationTitle();
				} else
				if ($mod instanceof xyo_Module) {
					$mod->loadLanguage();
					$moduleName = $mod->getFromLanguage("application.title",$dsModule->name);
				};				
			};

			$this->setApplicationTitle($this->getFromLanguage("application.title") . " - " . $moduleName);
			$this->addModule($dsModule->name);
			$this->requireComponent(array_keys($this->elements));
        	};
	};    

};

// 
// Keep caller
//
$this->keepRequestStack();
