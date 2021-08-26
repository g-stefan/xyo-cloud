<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$this->setHtmlJsSourceOrAjaxCsrfToken();
$this->generateView("notify-alert");
$this->generateView("notify-error");

// ---

echo "<div style=\"height:240px;\"></div>";
$this->ejsBegin();
echo "XUI.Modal.deactivate();";
echo "XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."action=table-view\");";
$this->ejsEnd();
