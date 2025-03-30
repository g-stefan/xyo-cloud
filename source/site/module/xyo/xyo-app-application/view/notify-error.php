<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if($this->useNotify) {
	if($this->isError()){
		if($this->getError()==="element"){
			return;
		};

		$msgLang = "error.unknown";
		$msgTxt = "";
		$msg = $this->getError();
		if ($msg) {
			if (is_array($msg)) {
				reset($msg);
				$msgLang = key($msg);
				$msgTxt = current($msg);
			} else {
				$msgLang = $msg;
			};
		};

		$html = "";
	        if (strlen($msgTxt)) {
			$html = "<strong>".$this->getFromLanguage($msgLang)."</strong>";
			$html .= $msgTxt;
		} else {
			$html = $this->getFromLanguage($msgLang);
		};

		$this->setHtmlJsSourceorAjax("XUI.Notify.newNotification(\"".$html."\",\"danger\");","load");
	};
};
