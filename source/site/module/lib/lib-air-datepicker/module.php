<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_AirDatePicker";

class lib_AirDatePicker extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_AirDatePicker")) {
			$this->setHtmlCss($this->site."lib/air-datepicker.css");
			$this->setHtmlJs($this->site."lib/air-datepicker.js");
			$this->setHtmlJs($this->site."lib/air-datepicker.locale/en.js");
        	}
	}

}
