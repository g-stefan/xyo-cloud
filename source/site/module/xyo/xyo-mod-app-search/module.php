<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_mod_app_Search";

class xyo_mod_app_Search extends xyo_Module {

	function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("xyo_mod_app_Search")) {
			$this->setHtmlCss($this->site."lib/xyo/xyo-mod-app-search.css");
			$this->setHtmlJs($this->site."lib/xyo/xyo-mod-app-search.js");
        	}
	}
	
	public function moduleMain() {
		$this->generateView();
	}

}
