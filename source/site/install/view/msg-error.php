<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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
	<div class="xui alert -danger">
		<b><?php $this->eLanguage($msgLang); ?></b> <?php echo $msgTxt; ?> 	
	</div>
<?php
};

