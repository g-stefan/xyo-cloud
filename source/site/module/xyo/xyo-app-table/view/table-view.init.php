<?php                                                                   
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$has_search=false;
foreach ($this->tableSearch as $key => $value) {
	if ($value) {
		$has_search=true;
	};
};

$select_info = $this->getParameterInstance("select.info", array());
$search_value = $this->getParameterInstance("search_value", "");
$select_value = $this->getParameterInstance("select.value", array());
$nr_items = $this->getParameterInstance("nr_items", 0);
$count = $this->getParameterInstance("count", 10);
$page = $this->getParameterInstance("page", 1);
$sortState = $this->getParameterInstance("sortState", array());

if ($count > 0) {
	$page_count = ceil($nr_items / $count);
} else {
	$page_count = 1;
}

$sort_img = array(
	"ascendent" => "<i class=\"material-icons\">expand_more</i>",
	"descendent" => "<i class=\"material-icons\">expand_less</i>",
	"none" => ""
);

$toggle_img = array(
	0 => array("<i class=\"material-icons\">clear</i>","danger"),
	1 => array("<i class=\"material-icons\">done</i>","success")
);

$toggle_off_img = array(
	0 => "<i class=\"material-icons\">clear</i>",
	1 => "<i class=\"material-icons\">done</i>"
);

$sortNextState=array(
	"none" => "ascendent",
	"ascendent" => "descendent",
	"descendent" => "ascendent"
);
