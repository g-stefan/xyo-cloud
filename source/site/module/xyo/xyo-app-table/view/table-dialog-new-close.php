<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->generateView("notify-alert");
$this->generateView("notify-error");

// ---
$this->ecssBegin();
echo ".xyo-app-table.-x-new-close-1{height:240px;}";
$this->ecssEnd();

echo "<div class=\"xyo-app-table -x-new-close-1\"></div>";
$this->ejsBegin();
echo "XUI.Modal.deactivate();";
echo "XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."action=table-view\");";
$this->ejsEnd();
