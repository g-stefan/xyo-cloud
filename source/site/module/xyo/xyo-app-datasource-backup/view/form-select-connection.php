<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$connection=$this->getElementValueString("connection","db");
?>
<select class="xui-form-select" name="<?php $this->eElementName("connection"); ?>" id="<?php $this->eElementId("connection"); ?>" >
<?php
	$selectConnection=$this->getParameter("select.connection",array());
        foreach ($selectConnection as $value) {
        	$selected = "";
                if ($value === $connection) {
			$selected = "selected=\"selected\" ";
		};
		echo "<option value=\"" . $value . "\" " . $selected . ">" . $value . "</option>";
	};
?>
</select>			
