<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$layer = $this->getElementValue("layer", "xyo");
$layerList = array(
	"xyo",
	"csv",
	"sqlite",
	"mysqli",
	"mysql",
	"postgresql"
);

$this->generateComponent("xui.form-action-begin");

echo "<div class=\"float-right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"default",
	"try"=>"disabled",
	"next"=>"primary"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";

if ($this->isError()) {
	$this->generateView("msg-error");
}

?>

	<select class="xui-form-select" id="<?php $this->eElementName("layer"); ?>" name="<?php $this->eElementName("layer"); ?>">
<?php
                    foreach ($layerList as $value) {
                        $selected = "";
                        if ($value === $layer) {
                            $selected = "selected=\"selected\" ";
                        }
                        echo "<option value=\"" . $value . "\" " . $selected . ">" . $value . "</option>";
                    }

?>
	</select>
	<div class="clear-both h-4"></div>
                
        <?php $this->generateViewLanguage("form-datasource-" . $layer); ?>
                    
<?php

                    $this->eFormRequest(array(
                        "back" => "check",
                        "this" => "datasource",
                        "next" => "datasource-check",
                        "website_language" => $this->getSystemLanguage(),
                        "select" => "datasource"
                    ));

$this->generateComponent("xui.form-action-end");

$this->ejsBegin();
echo "document.getElementById(\"".$this->getElementName("layer")."\").onchange=function(){this.form.submit();};";
$this->ejsEnd();
echo "<div class=\"clear-both h-4\"></div>";
