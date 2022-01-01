<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if ($this->isError()) {
	$msg_lang = "error.unknown";
	$msg_txt = "";
	$err = $this->getError();
	if ($err) {
		if (is_array($err)) {
			reset($err);
			$msg_lang = key($err);
			$msg_txt = current($err);
		} else {
			$msg_lang = $err;
		};
	};
?>

<div class="xui alert -danger">
	<?php $this->eLanguage($msg_lang); ?>
	<?php echo $msg_txt; ?>
</div>

<?php

};
