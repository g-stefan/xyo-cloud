<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
$uid=$this->getUID();
$this->ecssBegin();
echo ".".$uid." {";
echo "color: #AA0000;";
echo "}";
$this->ecssEnd();

$path = $this->getParameter("path", array());
$allOk = true;
foreach ($path as $key => $value) {
	if ($value == "yes") {
		continue;
	};
	$allOk = false;
	break;
};			


$this->generateComponent("xui.form-action-begin");

echo "<div class=\"float-right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"default",
	"try"=>"default",
	"next"=>$allOk?"primary":"disabled"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";

if($allOk){
	$this->generateViewLanguage("msg-check-ok");
}else{
	$this->generateViewLanguage("msg-check-error");
	echo "<br />";
	echo "<div class=\"xui-list-group\">";
	echo "<div class=\"xui-list-group_content\">";

		foreach ($path as $key => $value) {
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
	echo "<br />";
	echo "<br />";
};


$this->eFormRequest(array(
	"back" => "license",
	"this" => "check",
	"next" => "datasource",
	"website_language" => $this->getSystemLanguage()
));

$this->generateComponent("xui.form-action-end");
echo "<div class=\"clear-both h-4\"></div>";
