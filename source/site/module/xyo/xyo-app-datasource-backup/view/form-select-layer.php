<?php
// Copyright (c) 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$layer=$this->getElementValueString("layer","xyo");

?>
<select class="xui form-select" name="<?php $this->eElementName("layer"); ?>" id="<?php $this->eElementId("layer"); ?>" onChange="this.form.submit();">
<?php
	$list_layer=$this->getParameter("select.layer",array());
	foreach ($list_layer as $value) {
		$selected = "";
		if ($value === $layer) {
			$selected = "selected=\"selected\" ";
		};
		echo "<option value=\"" . $value . "\" " . $selected . ">" . $value . "</option>";
	};
?>
</select>

