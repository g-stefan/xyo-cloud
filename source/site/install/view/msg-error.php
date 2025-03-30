<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

if ($this->isError()) {
	$msgLang = "error.unknown";
	$msgTxt = "";
	$err = $this->getError();
	if ($err) {
		if (is_array($err)) {
			reset($err);
			$msgLang = key($err);
			$msgTxt = current($err);
		} else {
			$msgLang = $err;
		};
	};
	if($msgLang === "element"){
		return;
	};
?>
	<div class="xui-alert --danger">
		<b><?php $this->eLanguage($msgLang); ?></b> <?php echo $msgTxt; ?> 	
	</div>
<?php
};

