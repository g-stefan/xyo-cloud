<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->processModel("datasource-init");

$selectDatasource = $this->getParameter("select.datasource", array());
$allOk = true;
foreach ($selectDatasource as $key => $value) {
	if ($value == "yes") {
		continue;
	};
	$allOk = false;
	break;
};

$uid=$this->getUID();
$this->ecssBegin();
echo ".".$uid." {";
echo "color: #AA0000;";
echo "}";
$this->ecssEnd();


$this->generateComponent("xui.form-action-begin");

echo "<div class=\"float-right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"default",
	"try"=>$allOk?"disabled":"default",
	"next"=>$allOk?"primary":"disabled"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";

if($allOk){
	$this->generateViewLanguage("msg-install-ok");
}else{
	if ($this->isError()) {
		$this->generateView("msg-error");
	}

	echo "<br />";
	echo "<div class=\"xui-list-group\">";
	echo "<div class=\"xui-list-group_content\">";

	foreach ($listDatasource as $key => $value) {
		if ($value == "yes") {
			continue;
		};
		echo "<div class=\"xui-list-group_item\">";
			echo "<div class=\"xui-list-group_item_text\">";
	                        echo $key;
			echo "</div>";			
			echo "<div class=\"xui-list-group_item_icon-right ".$uid."\">";
				echo "<i class=\"lucide-alert-octagon\"></i>";
                	echo "</div>";
        	echo "</div>";
	};

	echo "</div>";
	echo "</div>";
};

echo "<br />";
echo "<br />";

$this->eFormRequest(array(
	"back" => "datasource",
	"this" => "install",
	"next" => "settings",
	"website_language" => $this->getSystemLanguage()
));

$this->generateComponent("xui.form-action-end");

echo "<div class=\"clear-both h-4\"></div>";
