<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$layer = $this->getElementValue("layer", "xyo");

$configFileName = null;
$fileName = "config/datasource.db.php";
$moduleName = "";
if ($layer === "xyo") {    
	$moduleName = "xyo-datasource-xyo";
} else
if ($layer === "csv") {
	$moduleName = "xyo-datasource-csv";
} else
if ($layer === "mysqli") {
	$moduleName = "xyo-datasource-mysqli";
} else
if ($layer === "mysql") {
	$moduleName = "xyo-datasource-mysql";
} else
if ($layer === "postgresql") {
	$moduleName = "xyo-datasource-postgresql";
} else
if ($layer === "sqlite") {
	$moduleName = "xyo-datasource-sqlite";
} else {
	$this->setError(array("error.unknown_layer" => $layer));
	return;
};

$configFileName = $fileName;

$this->setParameter("config_file", $configFileName);

$fileHandle = null;
if ($fileName) {
	$fileHandle = fopen($fileName, "w");
};

if ($fileHandle) {
	fwrite($fileHandle, "<" . "?" . "php\r\n");
	fwrite($fileHandle, "defined(\"XYO_CLOUD\") or die(\"Access is denied\");\r\n");
	fwrite($fileHandle, "// \r\n");
	fwrite($fileHandle, "// Data Source Layer Config\r\n");
	fwrite($fileHandle, "// \r\n");

	if ($layer === "xyo") {
		fwrite($fileHandle, "\$this->setDataSourceConnectionProvider(" .
                	"\"db\",array(\r\n".
			"\t\"type\"=>\"".$moduleName."\",\r\n".
			"\t\"repository\"=>\"repository/datasource/db/\"\r\n".
			"));\r\n");
	} else
	if ($layer === "csv") {
		fwrite($fileHandle, "\$this->setDataSourceConnectionProvider(" .
                	"\"db\",array(\r\n".
			"\t\"type\"=>\"".$moduleName."\",\r\n".
			"\t\"repository\"=>\"repository/datasource/db/\"\r\n".
			"));\r\n");
	} else
	if ($layer === "mysqli") {
        	fwrite($fileHandle, "\$this->setDataSourceConnectionProvider(" .
			"\"db\",array(\r\n".
			"\t\"type\"=>\"".$moduleName."\",\r\n".
			"\t\"username\"=>\"".addslashes($this->getElementValueString("username"))."\",\r\n".
			"\t\"password\"=>\"".addslashes($this->getElementValueString("password"))."\",\r\n".
			"\t\"server\"=>\"".addslashes($this->getElementValueString("server"))."\",\r\n".
			"\t\"port\"=>\"".addslashes($this->getElementValueString("port"))."\",\r\n".
			"\t\"database\"=>\"".addslashes($this->getElementValueString("database"))."\",\r\n".
			"\t\"prefix\"=>\"".addslashes($this->getElementValueString("prefix"))."\",\r\n".
			"\t\"force.use\"=>false,\r\n".
			"\t\"debug\"=>false,\r\n".
			"\t\"log\"=>false\r\n".
			"));\r\n");
	} else
	if ($layer === "mysql") {
        	fwrite($fileHandle, "\$this->setDataSourceConnectionProvider(" .
			"\"db\",array(\r\n".
			"\t\"type\"=>\"".$moduleName."\",\r\n".
			"\t\"username\"=>\"".addslashes($this->getElementValueString("username"))."\",\r\n".
			"\t\"password\"=>\"".addslashes($this->getElementValueString("password"))."\",\r\n".
			"\t\"server\"=>\"".addslashes($this->getElementValueString("server"))."\",\r\n".
			"\t\"port\"=>\"".addslashes($this->getElementValueString("port"))."\",\r\n".
			"\t\"database\"=>\"".addslashes($this->getElementValueString("database"))."\",\r\n".
			"\t\"prefix\"=>\"".addslashes($this->getElementValueString("prefix"))."\",\r\n".
			"\t\"force.use\"=>false,\r\n".
			"\t\"debug\"=>false,\r\n".
			"\t\"log\"=>false\r\n".
			"));\r\n");
	} else
	if ($layer === "postgresql") {
        	fwrite($fileHandle, "\$this->setDataSourceConnectionProvider(" .
			"\"db\",array(\r\n".
			"\t\"type\"=>\"".$moduleName."\",\r\n".
			"\t\"username\"=>\"".addslashes($this->getElementValueString("username"))."\",\r\n".
			"\t\"password\"=>\"".addslashes($this->getElementValueString("password"))."\",\r\n".
			"\t\"server\"=>\"".addslashes($this->getElementValueString("server"))."\",\r\n".
			"\t\"port\"=>\"".addslashes($this->getElementValueString("port"))."\",\r\n".
			"\t\"database\"=>\"".addslashes($this->getElementValueString("database"))."\",\r\n".
			"\t\"prefix\"=>\"".addslashes($this->getElementValueString("prefix"))."\",\r\n".
			"\t\"debug\"=false,\r\n".
			"\t\"log\"=>false\r\n".
			"));\r\n");
	} else
	if ($layer === "sqlite") {
		fwrite($fileHandle, "\$this->setDataSourceConnectionProvider(" .
                	"\"db\",array(\r\n".
			"\t\"type\"=>\"".$moduleName."\",\r\n".
			"\t\"database\"=>\"repository/datasource/db." . md5(date("l jS \of F Y h:i:s A")) . ".sqlite\",\r\n".
			"\t\"mode\"=>0666,\r\n".
			"\t\"prefix\"=>\"\",\r\n".
			"\t\"debug\"=>false,\r\n".
			"\t\"log\"=>false\r\n".
			"));\r\n");
	};

	fwrite($fileHandle, "\r\n\r\n");
	fclose($fileHandle);
} else {
	$this->setError(array("error.config_not_writable" => $fileName));
	return;
};

$this->cloud->dataSource->loadConfig();

if (!$this->isError()) {
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
};

