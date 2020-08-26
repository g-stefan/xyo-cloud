<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_TinyMCE";

class lib_TinyMCE extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_TinyMCE")) {
			$this->setHtmlJs($this->site."lib/tinymce/tinymce.min.js");
			$this->setHtmlJs($this->site."lib/tinymce/jquery.tinymce.min.js");
		}
	}

}
