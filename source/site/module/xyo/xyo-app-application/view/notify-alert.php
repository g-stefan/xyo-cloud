<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if($this->useNotify) {
	if($this->isAlert()){

		$msgLang = "alert.unknown";
		$msgTxt = "";
		$msg = $this->getAlert();
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

		$this->setHtmlJsSourceorAjax("XUI.Notify.newNotification(\"".$html."\",\"info\");","load");
	};
};
