<?php
//
// Copyright (c) 2020-2022 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if($this->filterHasSearch_) { ?>
	<label class="xui form-label" for="<?php echo $this->instanceV; ?>fn_filter_search"><?php $this->eLanguage("search"); ?></label>
	<br />
	<div class="xui form-input-group" style="width:100%;">
		<input type="text" name="<?php echo $this->instanceV; ?>search" value="" style="width:calc(100% - 30px);" placeholder="" id="<?php echo $this->instanceV; ?>fn_filter_search"></input>
		<button type="button" name="<?php echo $this->instanceV; ?>search_reset" onclick="this.form.elements['<?php echo $this->instanceV; ?>search'].value='';"><i class="material-icons">close</i></button>
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
