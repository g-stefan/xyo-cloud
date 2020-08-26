<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

function xyo_Cloud_Request__stripSlashesDeep($value) {
	return is_array($value) ? array_map("xyo_Cloud_Request__stripSlashesDeep", $value) : stripslashes($value);
}
