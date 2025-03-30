<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

function xyo_Cloud_Request__stripSlashesDeep($value) {
	return is_array($value) ? array_map("xyo_Cloud_Request__stripSlashesDeep", $value) : stripslashes($value);
}
