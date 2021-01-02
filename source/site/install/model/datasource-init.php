<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$conDb = &$this->cloud->dataSource->getDataSourceConnection("db");
if ($conDb) {
	if ($conDb->open()) {
		$conDb->close();
	} else {
		$this->setError(array("error.connection_error" => "db"));
		return;
	};
} else {
	$this->setError(array("error.connection_unknown" => "db"));
	return;
};

$setup = &$this->cloud->getModule("xyo-mod-setup");
if (!$setup) {
	$this->setError("error.unable_to_instantiate_setup");
	return;
};

$setup->registerDataSource("db.table.xyo_settings");
$setup->registerDataSource("db.table.xyo_language");
$setup->registerDataSource("db.table.xyo_module");
$setup->registerDataSource("db.table.xyo_module_group");
$setup->registerDataSource("db.table.xyo_module_parameter");
$setup->registerDataSource("db.table.xyo_core");
$setup->registerDataSource("db.table.xyo_acl_module");
$setup->registerDataSource("db.table.xyo_user");
$setup->registerDataSource("db.table.xyo_user_group");
$setup->registerDataSource("db.table.xyo_user_group_x_user_group");
$setup->registerDataSource("db.table.xyo_user_x_user_group");

//---
$order = array();
$listDatasource=array();

include($this->path . "repository/_order.php");

	$allOk = true;
	foreach ($order as $level_ => $source_) {
		$value = "yes";
		$dataSource = &$this->getDataSource($source_);
		if ($dataSource) {
			$filename = $this->path . "repository/" . $source_ . ".php";
			if (file_exists($filename)) {
				include($filename);
			};
		} else {
			$value = "no";
			$allOk = false;
		};

		$listDatasource[$source_]=$value;
	};

if (!$allOk) {
	$this->setError("error.datasource_init");
};

$this->setParameter("select.datasource", $listDatasource);

