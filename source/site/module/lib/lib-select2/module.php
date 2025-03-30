<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_Select2";

class lib_Select2 extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_Select2")) {
			$this->setHtmlCss($this->site."lib/select2.min.css");
			$this->setHtmlJs($this->site."lib/select2.full.min.js");
			$this->setHtmlJs($this->site."lib/select2.locale/en.js");
        	}
	}

}
