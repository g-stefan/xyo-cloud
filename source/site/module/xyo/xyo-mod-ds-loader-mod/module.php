<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
			$this->dsModuleParameter = &$this->getDataSource("db.table.xyo_module_parameter");

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

				$parameter = array();
				if ($dsModule->parameter) {
					$this->dsModuleParameter->clear();
					$this->dsModuleParameter->xyo_module_id=$dsModule->id;
					for($this->dsModuleParameter->load(); $this->dsModuleParameter->isValid(); $this->dsModuleParameter->loadNext()) {
						$parameter[$this->dsModuleParameter->name]=$this->dsModuleParameter->value;
					};
				};

				$this->cloud->setModule($dsModule->parent, $dsModule->path, $dsModule->name, true, $parameter, true, false);

				return true;
			};

			$this->cloud->setModule($dsModule->parent, $dsModule->path, $name, false, null, true, false);

			return true;
		};

		$this->cloud->setModule(null, null, $name, false, null, false, true, false);
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

