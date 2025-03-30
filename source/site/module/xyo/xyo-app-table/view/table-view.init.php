<?php                                                                   
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT


defined("XYO_CLOUD") or die("Access is denied");

$has_search=false;
foreach ($this->tableSearch as $key => $value) {
	if ($value) {
		$has_search=true;
		break;
	};
};

$select_info = $this->getParameterInstance("select.info", array());
$search_value = $this->getParameterInstance("search_value", "");
$select_value = $this->getParameterInstance("select.value", array());
$nr_items = $this->getParameterInstance("nr_items", 0);
$count = $this->getParameterInstance("count", 10);
$page = $this->getParameterInstance("page", 1);
$sortState = $this->getParameterInstance("sortState", array());

$page_count = 1;
if($count !== "all") {
	if ($count > 0) {	
		$page_count = ceil($nr_items / $count);
	};
};

$sort_img = array(
	"ascendent" => "<i class=\"lucide-chevron-down\"></i>",
	"descendent" => "<i class=\"lucide-chevron-up\"></i>",
	"none" => ""
);

$toggle_img = array(
	0 => array("<i class=\"lucide-x\"></i>","danger"),
	1 => array("<i class=\"lucide-check\"></i>","success")
);

$toggle_off_img = array(
	0 => "<i class=\"lucide-x\"></i>",
	1 => "<i class=\"lucide-check\"></i>"
);

$sortNextState=array(
	"none" => "ascendent",
	"ascendent" => "descendent",
	"descendent" => "ascendent"
);
