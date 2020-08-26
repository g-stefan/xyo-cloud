<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_IonIcons";

class lib_IonIcons extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_IonIcons")) {
			$this->setHtmlJs($this->site."lib/ionicons/ionicons.esm.js","data-stencil-namespace=\"ionicons\" type=\"module\" defer");
			$this->setHtmlJs($this->site."lib/ionicons/ionicons.js","data-stencil-namespace=\"ionicons\" nomodule=\"\" defer");
		};
	}

}
