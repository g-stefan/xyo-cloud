<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

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

echo "<div class=\"xui -right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"default",
	"try"=>"disabled",
	"next"=>"primary"
)));
echo "</div>";
echo "<div class=\"xui separator\"></div>";
echo "<br />";

if ($this->isError()) {
	$this->generateView("msg-error");
}

?>

	<select class="xui form-select" id="<?php $this->eElementName("layer"); ?>" name="<?php $this->eElementName("layer"); ?>">
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
	<br/>
                
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
