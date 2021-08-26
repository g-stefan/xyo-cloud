<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->generateView("notify-alert");
$this->generateView("notify-error");

// ---

$this->setParameter("form.title","form.title_filter");
$this->generateComponent("xui.form-action-begin",array("onsubmit"=>"XYO.Table.doUpdate('".$this->instance."','&".$this->instanceV."action=table-view');"));

$this->generateView("table-dialog-filter-form");

// load selected filters
$this->ejsBegin();
if($this->filterHasSearch_) {
		echo "\$(\"#".$this->instanceV."fn_filter_search\").val(\$(\"#".$this->instanceV."search\").val());";
};
foreach ($this->tableSelect as $key => $value) {
	if($value){
		if(strcmp($value,"multiple")==0){
			echo "\$(\"#".$this->instanceV."fn_filter_e_" . $key."\").val(\$(\"#".$this->instanceV."view_select_" . $key."\").val().split(\",\")).trigger(\"change\");";
			continue;
		};
		echo "\$(\"#".$this->instanceV."fn_filter_e_" . $key."\").val(\$(\"#".$this->instanceV."view_select_" . $key."\").val()).trigger(\"change\");";
	};
};
$this->ejsEnd();