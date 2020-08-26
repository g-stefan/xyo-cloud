<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_XUI";

class lib_XUI extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_XUI")) {
			$this->setHtmlCss($this->site."lib/xui/xui.complete.min.css");
			$this->setHtmlJs($this->site."lib/xui/xui.complete.min.js");
		}
	}

}
