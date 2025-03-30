<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "lib_JQueryTagEditor";

class lib_JQueryTagEditor extends xyo_Module {

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);
		if ($this->isBase("lib_JQueryTagEditor")) {
			$this->setHtmlCss($this->site."lib/jquery.tag-editor.css");
			$this->setHtmlJs($this->site."lib/jquery.caret.min.js");
			$this->setHtmlJs($this->site."lib/jquery.tag-editor.min.js");
		}
	}

}
