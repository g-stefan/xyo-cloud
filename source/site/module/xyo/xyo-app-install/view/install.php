<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.form-action-begin");

echo "<div class=\"xui -right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"disabled",
	"try"=>"disabled",
	"next"=>"primary"
)));
echo "</div>";
echo "<div class=\"xui separator\"></div>";
echo "<br />";

$mode = $this->getRequest("mode");
$package = $this->getRequest("package");

$listModuleToCheck = array();
$listModuleToCheck2 = array();
$orderModule = array();
$packagePath =  "package/";
$dsModule = &$this->getDataSource("db.table.xyo_module");
$modSetup = &$this->cloud->getModule("xyo-mod-setup");

if ($modSetup && $dsModule) {

	if ($mode === "all") {
		$listModuleToCheck = $modSetup->getPackageList2($packagePath);
	} else {
		$listModuleToCheck = array($package => $package);
	};

	foreach ($listModuleToCheck as $key => $value) {
		$key2 = $modSetup->getModuleNameFromVer($key);
		$listModuleToCheck2[$key2] = $key;
	};

	foreach ($listModuleToCheck2 as $key => $value) {
		$orderModule[$key] = 1;
	};

	foreach ($listModuleToCheck2 as $key => $value) {
		$requireModule = $modSetup->getPackageLink($value);
		foreach ($requireModule as $key2 => $value2) {
			if (array_key_exists($key2, $orderModule)) {
				++$orderModule[$key2];
			} else {
				$orderModule[$key2] = 1;
			}
		}
	};

	$orderModule2 = array();
	foreach ($listModuleToCheck2 as $key => $value) {
		$orderModule2[$key] = $orderModule[$key];
	};

	arsort($orderModule2);

	$error = false;

	echo "<ul class=\"xui list-group\">";			

	foreach ($orderModule2 as $key => $value) {
		$ret = $modSetup->installModulePackage($listModuleToCheck2[$key]);
		if (count($ret)) {
			$doUpdate = false;
			$dsModule->clear();
			$dsModule->name = $ret["module"];
			if ($dsModule->load()) {
				$doUpdate = true;
			};

			if ($modSetup->registerModule($ret["parent"], null, $ret["module"])) {
				$modSetup->setModule($ret["parent"], null, $ret["module"], true,false,true);

				if ($doUpdate) {
					if ($modSetup->runModuleUpdate($ret["module"])) {
						echo "<li>";
							echo "<span>".$ret["module"]."</span>";
							echo "<i class=\"material-icons\">done</i>";
						echo "</li>";
					} else {
						echo "<li>";
							echo "<span>".$ret["module"]."</span>";
							echo "<i class=\"material-icons\">highlight_off</i>";
						echo "</li>";
						$error = true;
					};
				} else {
					if ($modSetup->runModuleInstall($ret["module"])) {
						echo "<li>";
							echo "<span>".$ret["module"]."</span>";
							echo "<i class=\"material-icons\">done</i>";
						echo "</li>";
					} else {
						echo "<li>";
							echo "<span>".$ret["module"]."</span>";
							echo "<i class=\"material-icons\">highlight_off</i>";
						echo "</li>";
						$error = true;
					};
                		};
            		};
		} else {
			echo "<li>";
				echo "<span>".$ret["module"]."</span>";
				echo "<i class=\"material-icons\">highlight_off</i>";
			echo "</li>";
			$error = true;
        	};
    	};

	echo "</ul>";

	if ($error) {
		$this->setError("error.module_install");
		$this->generateView("msg-error");
	};
};

$this->generateComponent("xui.form-action-end");
