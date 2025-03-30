<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if(!$this->dsPrimaryKeyLoad()){
	return;
};

if ($this->xyo_module_id) {
	$this->ds->xyo_module_id = $this->xyo_module_id;
} else {
	$this->ds->xyo_module_id = $this->getElementValueNumber("xyo_module_id");
	if($this->ds->xyo_module_id==0){
		$this->setElementErrorFromLanguage("xyo_module_id", "not_selected");
		return;
	};
};

if ($this->xyo_module_group_id) {
	$this->ds->xyo_module_group_id = $this->xyo_module_group_id;
} else {
	$this->ds->xyo_module_group_id = $this->getElementValueNumber("xyo_module_group_id");
};

$this->ds->xyo_core_id = $this->getElementValueNumber("xyo_core_id");
$this->ds->xyo_user_group_id = $this->getElementValueNumber("xyo_user_group_id");
$this->ds->tryLoad();
$this->ds->order = $this->getElementValueNumber("order");
$this->ds->enabled = $this->getElementValueNumber("enabled");

$this->processModel("select-xyo-module");

$list_xyo_module_id = $this->getParameter("select.xyo_module_id", array());
if (array_key_exists($this->ds->xyo_module_id, $list_xyo_module_id)) {
	$this->ds->module = $list_xyo_module_id[$this->ds->xyo_module_id];
};

if (!$this->ds->save()) {
	$this->setError("error.save");
};
