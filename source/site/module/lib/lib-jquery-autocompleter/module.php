<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_jqueryAutocompleter";

class lib_jqueryAutocompleter extends xyo_Module {

	public function __construct(&$object, &$cloud) {
        	parent::__construct($object, $cloud);
		if ($this->isBase("lib_jqueryAutocompleter")) {
			$this->setHtmlCss($this->site."lib/jquery-autocompleter/jquery.autocompleter.css");
			$this->setHtmlJs($this->site."lib/jquery-autocompleter/jquery.autocompleter.min.js");
		}
	}

}
