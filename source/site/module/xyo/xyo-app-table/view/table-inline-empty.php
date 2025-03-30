<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->ecssBegin();
echo ".xyo-app-table.--x-inline-empty-1{position:relative;width:100%;min-height:320px;}";
echo ".xyo-app-table.--x-inline-empty-2{height:320px;}";
echo ".xyo-app-table.--x-inline-empty-3{border-radius:50%;width:64px;height:64px;background-color:#EEEEEE;overflow:hidden;}";
$this->ecssEnd();
?>
<div class="xyo-app-table --x-inline-empty-1">
	<div class="flex flex-col items-center justify-center xyo-app-table --x-inline-empty-2">
		<div class="xyo-app-table --x-inline-empty-3">
		</div>
	</div>
</div>