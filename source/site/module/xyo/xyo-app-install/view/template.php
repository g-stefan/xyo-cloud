<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$view = $this->getView();

$listGroup = array(
	array("id"=>1,"key"=>"welcome","text"=>$this->getFromLanguage("panel.welcome"),"selected"=>false,"icon-left" => ""),
	array("id"=>2,"key"=>"package","text"=>$this->getFromLanguage("panel.package"),"selected"=>false,"icon-left" => ""),
	array("id"=>3,"key"=>"require","text"=>$this->getFromLanguage("panel.require"),"selected"=>false,"icon-left" => ""),
	array("id"=>4,"key"=>"license","text"=>$this->getFromLanguage("panel.license"),"selected"=>false,"icon-left" => ""),
	array("id"=>5,"key"=>"install","text"=>$this->getFromLanguage("panel.install"),"selected"=>false,"icon-left" => "")	
);

foreach ($listGroup as $key => &$value) {
	if ($value["key"] === $view) {
		$value["selected"] = true;
		$value["icon-left"] = "<i class=\"lucide-chevron-right\"></i>";
	};
};

?>

<div class="xyo install-application-top-space"></div>

<?php

$this->generateComponent("xui.box-x-900-begin");
$this->generateComponent("xui.panel2-begin");
$this->eLanguage("alt_install");
$this->generateComponent("xui.panel2-content");

?>

<div class="xyo install-application">
	<div class="xyo install-application_panel">
		<?php $this->generateComponent("xui.list-group", array("items"=>$listGroup)); ?>
		<img class="xyo install-application_image" src="<?php echo $this->site; ?>lib/xyo/system-installer-2-128.png"
			alt="<?php $this->eLanguage("alt_install"); ?>" ></img>
	</div>
	<div class="xyo install-application_content">
		<?php $this->generateCurrentView(); ?>
	</div>
</div>

<?php

$this->generateComponent("xui.panel2-end");
$this->generateComponent("xui.box-x-900-end");
