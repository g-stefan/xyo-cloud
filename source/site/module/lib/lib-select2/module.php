<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_Select2";

class lib_Select2 extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_Select2")) {
			$this->setHtmlCss($this->site."lib/select2/select2.min.css");
			$this->setHtmlJs($this->site."lib/select2/select2.full.min.js");
			$this->setHtmlJs($this->site."lib/select2/i18n/en.js");
        	}
	}

}
