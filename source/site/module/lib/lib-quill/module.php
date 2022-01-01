<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_Quill";

class lib_Quill extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_Quill")) {
			$this->setHtmlCss($this->site."lib/quill/quill.snow.css");
			$this->setHtmlJs($this->site."lib/quill/quill.min.js");
		}
	}

}
