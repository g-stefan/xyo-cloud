<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

foreach ($this->viewData as $key => $value) {
	if (!$this->viewData[$key]["user_group"]) {
		$this->viewData[$key]["user_group"] = $this->getFromLanguage("select.xyo_user_group_none");;
	};
};
