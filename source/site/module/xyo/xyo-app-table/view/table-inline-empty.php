<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->ecssBegin();
echo ".xyo-app-table.-x-inline-empty-1{position:relative;width:100%;min-height:320px;}";
echo ".xyo-app-table.-x-inline-empty-2{height:320px;}";
echo ".xyo-app-table.-x-inline-empty-3{border-radius:50%;width:64px;height:64px;background-color:#EEEEEE;overflow:hidden;}";
$this->ecssEnd();
?>
<div class="xui xyo-app-table -x-inline-empty-1">
	<div class="xui center-xy xyo-app-table -x-inline-empty-2">
		<div class="xui xyo-app-table -x-inline-empty-3">
		</div>
	</div>
</div>