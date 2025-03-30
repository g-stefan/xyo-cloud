<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ecssBegin();
echo ".xyo-app-table.-x-filter-form-1{width:100%;}";
echo ".xyo-app-table.-x-filter-form-2{width:calc(100% - 30px);}";
$this->ecssEnd();
$uid=$this->getUID();
$this->ejsBegin();
echo "document.getElementById(\"".$uid."-search-reset\").onclick=function(){this.form.elements[\"".$this->instanceV."search\"].value=\"\";};";
$this->ejsEnd();

if($this->filterHasSearch_) { ?>
	<label class="xui-form-label" for="<?php echo $this->instanceV; ?>fn_filter_search"><?php $this->eLanguage("search"); ?></label>
	<br />
	<div class="xui-form-input-group xyo-app-table -x-filter-form-1">
		<input type="text" name="<?php echo $this->instanceV; ?>search" value="" class="xyo-app-table -x-filter-form-2" placeholder="" id="<?php echo $this->instanceV; ?>fn_filter_search"></input>
		<button type="button" name="<?php echo $this->instanceV; ?>search_reset" id="<?php echo $uid; ?>-search-reset"><i class="lucide-x"></i></button>
	</div>
	<br />
<?php };

foreach ($this->tableSelect as $key => $value) {
	if ($value) {
		$selectListFilter = $this->getParameter("select.".$key, array());
		$selectListFilter["*"] = $this->getFromLanguage("select.all");
		$this->setParameter("select.".$key, $selectListFilter);
		
		if(strcmp($value,"multiple")==0) {
			unset($selectListFilter["*"]);			
			$this->setParameter("select.".$key, $selectListFilter);	
			$this->generateComponent("xui.form-select-multiple", array("element" => $key));
			continue;
		};
		$this->generateComponent("xui.form-select", array("element" => $key, "minimum_results_for_search"=> 15));
	};
};
