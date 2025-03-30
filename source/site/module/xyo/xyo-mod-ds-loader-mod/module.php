<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_ds_Loader";

class xyo_mod_ds_Loader extends xyo_Module {

	var $dsModule;
	var $dsModuleGroup;
	var $dsModuleParameter;
	var $dsAclModule;

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);

		$this->modAcl = &$this->cloud->getModule("xyo-mod-ds-acl");

		if ($this->modAcl) {

			$this->dsModule = &$this->getDataSource("db.table.xyo_module");
			$this->dsModuleGroup = &$this->getDataSource("db.table.xyo_module_group");
			$this->dsAclModule = &$this->getDataSource("db.table.xyo_acl_module");			

			if (!($this->dsModule && $this->dsModuleGroup && $this->dsAclModule)) {
				$this->moduleDisable();
				return;
			};

		} else {
			$this->moduleDisable();
			return;
		};
	}

	function systemSetModule($name) {

		$dsModule = &$this->dsModule->copyThis();
		$dsModule->clear();
		$dsModule->name = $name;
		$dsModule->enabled = 1;
		if ($dsModule->load(0, 1)) {

			$dsAclModule = &$this->dsAclModule->copyThis();
			$dsAclModule->clear();
			$dsAclModule->xyo_module_id = $dsModule->id;
			$dsAclModule->enabled=1;
			$this->modAcl->setDsAclSys($dsAclModule);

			if($dsAclModule->load(0,1)) {

				$this->cloud->setModule($dsModule->parent, $dsModule->path, $dsModule->name);

				return true;
			};

			$this->cloud->setModule($dsModule->parent, $dsModule->path, $name, false, true, false);

			return true;
		};

		$this->cloud->setModule(null, null, $name, false, false, true);
		return true;
	}

	function systemSetGroup($name) {

		$dsModuleGroup = &$this->dsModuleGroup->copyThis();
		$dsModuleGroup->clear();
		$dsModuleGroup->name = $name;
		$dsModuleGroup->enabled = 1;
		if ($dsModuleGroup->load(0, 1)) {

			$dsAclModule = &$this->dsAclModule->copyThis();
			$dsAclModule->clear();
			$dsAclModule->xyo_module_group_id = $dsModuleGroup->id;
			$dsAclModule->enabled=1;
			$this->modAcl->setDsAclSys($dsAclModule);

			if($dsAclModule->load()) {
				for(; $dsAclModule->isValid(); $dsAclModule->loadNext()) {
					$this->cloud->setModuleGroup($dsAclModule->module, $name, $dsAclModule->order);
				};
			};
		};
		return false;
	}

}

