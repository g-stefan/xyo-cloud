<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->generateComponent("xui.form-action-begin");

echo "<div class=\"float-right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"default",
	"try"=>"default",
	"next"=>"primary"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";
echo "<br />";

$this->eLanguage("title.package");

echo "<br />";
echo "<br />";

$this->eFormRequest(array(
	"back" => "welcome",
	"this" => "package",
	"next" => "require",
	"select" => "package"
));

$mode = $this->getRequest("mode", "single");
$modeList = array(
	"single" => $this->getFromLanguage("mode_single"),
	"all" => $this->getFromLanguage("mode_all"),
);

?>

<label class="xui-form-label" for="mode"><?php $this->eLanguage("label.mode"); ?></label><br/>
<select class="xui-form-select" name="mode" id="mode" onChange="this.form.submit();">
<?php
foreach ($modeList as $key => $value) {
	$selected = "";
	if ($key === $mode) {
		$selected = "selected=\"selected\" ";
    	};
	echo "<option value=\"" . $key . "\" " . $selected . ">" . $value . "</option>";
};
?>
</select>
<br />

<?php if ($mode === "single") { ?>
	<label class="xui-form-label" for="package"><?php $this->eLanguage("label.package"); ?></label><br/>
	<select name="package" class="xui-form-select" id="name">
	<?php
	$this->processModel("select-packages");
	$packagesList = $this->getParameter("select.packages", array("*" => $this->getFromLanguage("package_none")));

	foreach ($packagesList as $key => $value) {
		$selected = "";
		if ($key === $mode) {
			$selected = "selected=\"selected\" ";
		};
		echo "<option value=\"" . $key . "\" " . $selected . ">" . $value . "</option>";
    	};
	?>
	</select>
<?php } else {

	echo "<br />";
	$this->processModel("select-packages");
	$packagesList = $this->getParameter("select.packages", array("*" => $this->getFromLanguage("package_none")));
	if (array_key_exists("*", $packagesList)) {
		$this->eLanguage("no_package_found");
	} else {
		echo "<span>";
		$this->eLanguage("label.package");
		echo "</span><br /><br />";
		foreach ($packagesList as $key => $value) {
			echo $key . "<br />";
        	};
    	};
};

$this->generateComponent("xui.form-action-end");
