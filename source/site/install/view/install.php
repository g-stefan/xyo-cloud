<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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

$this->generateComponent("xui.form-action-begin");

echo "<div class=\"xui -right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"default",
	"try"=>$allOk?"disabled":"default",
	"next"=>$allOk?"primary":"disabled"
)));
echo "</div>";
echo "<div class=\"xui separator\"></div>";
echo "<br />";

if($allOk){
	$this->generateViewLanguage("msg-install-ok");
}else{
	if ($this->isError()) {
		$this->generateView("msg-error");
	}

	echo "<br />";
	echo "<div class=\"xui list-group\">";
	echo "<div class=\"xui list-group_content\">";

	foreach ($listDatasource as $key => $value) {
		if ($value == "yes") {
			continue;
		};
		echo "<div class=\"xui list-group_item\">";
			echo "<div class=\"xui list-group_item_text\">";
	                        echo $key;
			echo "</div>";			
			echo "<div class=\"xui list-group_item_icon-right\" style=\"color: #AA0000;\">";
				echo "<i class=\"material-icons\">highlight_off</i>";
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
