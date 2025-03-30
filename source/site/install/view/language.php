<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");
$language = $this->getSystemLanguage();
$languageList = array(
	"en-GB" => $this->getFromLanguage("language.en_gb"),
        "ro-RO" => $this->getFromLanguage("language.ro_ro"),
);

$action=array();
if(!defined("XYO_CLOUD_ADMINISTRATOR")){
	$action=array("action"=>$this->siteBase."admin/");
}else{
	if(defined("XYO_CLOUD_ADMINISTRATOR")){
		if(defined("XYO_CLOUD_ROUTER_DEFAULT")){
			$action=array("action"=>$this->siteBase."admin/");
		};
	};
};

$this->generateComponent("xui.form-action-begin",$action);

echo "<div class=\"float-right\">";
$this->generateComponent("xui.form-submit-button-group",array("group"=>array(
	"back"=>"disabled",
	"try"=>"disabled",
	"next"=>"primary"
)));
echo "</div>";
echo "<div class=\"clear-both h-4\"></div>";

?>
	<label for="website_language" class="xui-form-label">
	<?php $this->generateViewLanguage("msg-language"); ?>
	</label>
	<br />
	<select class="xui-form-select -defult" id="website_language" name="website_language" data-xui-select-theme="-default">
<?php
                    foreach ($languageList as $key => $value) {
                        $selected = "";
                        if ($key === $language) {
                            $selected = "selected=\"selected\" ";
                        };
                        echo "<option value=\"" . $key . "\" " . $selected . ">" . $value . "</option>";
                    };

?>
	</select> 



<?php
	$this->eFormRequest(array(
        	"back" => "language",
		"this" => "language",
		"next" => "license"
	));

$this->generateComponent("xui.form-action-end");

$this->ejsBegin();
echo "document.getElementById(\"website_language\").onchange=function(){this.form.submit();};";
$this->ejsEnd();

echo "<div class=\"clear-both h-4\"></div>";
