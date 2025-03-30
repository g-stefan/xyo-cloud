<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

include("table-view.init.php");

$this->ecssBegin();
echo ".xyo-app-table.--x-1{width:100% !important;}";
echo ".xyo-app-table.--x-2{display:none !important;}";
echo ".xyo-app-table.--x-3{margin-left: 4px !important;}";
echo ".xyo-app-table.--x-4{margin-left:6px !important;}";
echo ".xyo-app-table.--x-5{display:none;position:absolute;top:0px;left:0px;bottom:0px;right:0px;z-index:100;background-color:rgba(128,128,128,0.2);backdrop-filter:blur(3px);}";
echo ".xyo-app-table.--x-6{height:100% !important;min-height:128px !important;}";
echo ".xyo-app-table.--x-7{margin-right:0 !important;margin-left:0 !important;}";
echo ".xyo-app-table.--x-8{margin-right:3px !important;margin-left:3px !important;}";
echo ".xyo-app-table.--x-x48{width:48px !important}";
echo ".xyo-app-table.--x-x64{width:64px !important}";
echo ".xyo-app-table.--x-9{font-size: 16px;line-height: 20px;font-weight: normal;margin-left:4px;margin-top: 6px;}";
echo ".xyo-app-table.--x-10{color: #999 !important;}";
echo ".xyo-app-table.--x-11{font-size: 14px;line-height: 18px;font-weight: normal;margin-left: 6px;margin-top: 3px;}";
echo ".xyo-app-table.--x-12{display:none;height:100%;width:100%;overflow:auto;}";
echo ".xyo-app-table.--x-13{line-height: 24px !important;}";
echo ".xyo-app-table.--x-14{float:left !important;}";
echo ".xyo-app-table.--x-15{position:relative;width:100%;min-height:240px;}";
echo ".xyo-app-table.--x-16{height:240px !important;}";
echo ".xyo-app-table.--x-inline-toolbar-1{position:relative;width:100%;min-height:240px;}";
echo ".xyo-app-table.--x-inline-toolbar-2{height:240px !important;}";
echo ".xyo-app-table.--z-1{cursor:pointer !important;}";
echo ".xyo-app-table.--z-2{cursor:default !important;}";
echo ".xyo-app-table.--z-3{color:#FFF !important;}";
echo ".xyo-app-table.--z-4{min-width: 130px !important;}";
echo ".xyo-app-table.--z-5{display:none !important;}";
$this->ecssEnd();

if(!$this->isInline){
	if($this->isAjax()&&($this->embeddedDialogStep==0)){
		$this->setHtmlJsSourceOrAjaxCsrfToken();
		require_once("table-view.sub.php");
		include("table-view.instance.php");
		$this->ejsBegin();
		echo "document.getElementById(\"".$this->instanceV."page\").value=\"".$page."\";";
		echo "document.getElementById(\"".$this->instanceV."page-count\").innerHTML=\"".$page_count."\";";
		echo "document.getElementById(\"".$this->instanceV."item-count\").innerHTML=\"".$nr_items."\";";
		echo "XUI.EffectRipple.init();";
		$this->ejsEnd();
		return;
	};
};

if(!$this->isEmbedded){ 
	if($this->isInlineForm){ echo "<div class=\"xyo-app-table --is-inline-form xui-component-table_table\">"; }; ?>
	<form id="<?php $this->eFormName(); ?>" name="<?php $this->eFormName(); ?>" method="POST" action="<?php $this->eFormAction(); ?>" 
	 class="xyo-app-table_form"
	 onsubmit="XYO.Table.doUpdate('');return false;" >
	 <?php $this->eFormCsrfToken(); ?>
<?php	};

if($this->isInlineForm){
	$this->generateView("table-inline-style-override");
};

$cssClass="--application";
if($this->isEmbedded){
	$cssClass="--no-top-toolbar --no-border-bottom-toolbar --table-border";
};
   
if(($this->hideTopToolbar_)&&(!$this->isInlineForm)){
	$cssClass.=" --hide-secondary-top-toolbar";
};

if($this->isInlineForm){
	$cssClass.=" --is-inline-form";
};

if($this->hideTopToolbar_) {
	$cssClass.=" --hide-top-toolbar";
};

if($this->tableUseApplicationSearch) {
	$cssClass.=" --use-application-search";
};

?>

<div class="xui-component-table <?php echo $cssClass;?>" id="<?php echo $this->instanceV; ?>component-table">
	<div class="xui-application-toolbar"></div>
	<div class="xui-application-toolbar --compact --wide">
		<div class="xui-application-toolbar_content">
		<?php if($this->isInlineForm && $has_search){ ?>
			<div class="xui-form-input-group xyo-app-table --x-1 <?php if($this->tableUseApplicationSearch){echo " --x-2";}; ?>">
				<input type="text" name="<?php echo $this->instanceV; ?>search" value="<?php echo $search_value; ?>" size="32" placeholder="<?php $this->eLanguage("search"); ?>" id="<?php echo $this->instanceV; ?>search" class="xyo-app-table_search -inline-form"></input>
				<?php $uid=$this->getUID();?>
				<button id="<?php echo $uid; ?>" type="submit" name="<?php echo $this->instanceV; ?>submit_search"><i class="lucide-search"></i></button>
				<?php
				$this->ejsBegin();
				echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."submit_search=1\");return false;};";
				$this->ejsEnd();
				?>
				<?php $uid=$this->getUID();?>
				<button id="<?php echo $uid; ?>" type="button" name="<?php echo $this->instanceV; ?>search_reset"><i class="lucide-x"></i></button>
				<?php
				$this->ejsBegin();
				echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.resetSearch(\"".$this->instance."\",this,\"".$this->instanceV."search\");};";
				$this->ejsEnd();
				?>
			</div>
		<?php } else { ?>
			<div class="grid grid-cols-2 grid-rows-1">				
					<div>
					<?php if($has_search){ ?>
						<div class="xui-form-input-group xyo-app-table <?php if($this->tableUseApplicationSearch){echo " --x-2";}; ?>">
							<input type="text" name="<?php echo $this->instanceV; ?>search" value="<?php echo $search_value; ?>" size="32" placeholder="<?php $this->eLanguage("search"); ?>" id="<?php echo $this->instanceV; ?>search" class="xyo-app-table_search"></input>
							<?php $uid=$this->getUID();?>
							<button id="<?php echo $uid; ?>" type="submit" name="<?php echo $this->instanceV; ?>submit_search"><i class="lucide-search"></i></button>
							<?php
							$this->ejsBegin();
							echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."submit_search=1\");return false;};";
							$this->ejsEnd();
							?>
							<?php $uid=$this->getUID();?>
							<button id="<?php echo $uid; ?>" type="button" name="<?php echo $this->instanceV; ?>search_reset"><i class="lucide-x"></i></button>
							<?php
							$this->ejsBegin();
							echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.resetSearch(\"".$this->instance."\",this,\"".$this->instanceV."search\");};";
							$this->ejsEnd();
							?>
						</div>
				        <?php }; ?>
					</div>  
					<div>
					<?php if($this->dialogFilter_){ ?>
						<div class="float-right">
						<?php $uid=$this->getUID();?>
						<div id="<?php echo $uid; ?>" class="xui-button --small  --transparent xui-effect-ripple --info --icon-left --toolbar">
							<i class="lucide-list-filter"></i>				
							<span><?php $this->eLanguage("label.filter"); ?></span>
						</div>
						<?php
							$this->ejsBegin();
							echo "document.getElementById(\"".$uid."\").onclick=function(){".$this->instanceV."cmdDialogFilter();};";
							$this->ejsEnd();
							?>
						</div>
					<?php } else {

	       					foreach (array_reverse($this->tableSelect,true) as $key => $value) {
							if ($value) { ?>
							<div class="float-right xyo-app-table --x-3">
							<select name="<?php echo $this->instanceV; ?>view_select_<?php echo $key; ?>"
								size="1"
								onChange="XYO.Table.doUpdate('<?php echo $this->instance; ?>');"
							   	class="xui-form-select xyo-app-table --x-4" id="<?php echo $this->instanceV; ?>view_select_<?php echo $key; ?>"
								data-xui-select-theme="--default"><?php
								foreach ($select_info[$key] as $key_ => $value_) {
									$selected = "";
									if (strcmp($key_, $select_value[$key]) == 0) {
										$selected = " selected=\"selected\"";
									};
									echo "<option value=\"" . $key_ . "\" " . $selected . ">" . $value_ . "</option>";
								};
			                		?></select>
							</div>
	                		<?php
							};
						};
					    };
					?>

					</div>			
			</div>
		<?php }; ?>
		</div>
	</div>
	<div class="xui-component-table_table xui-overlay-scrollbars">
        <table class="xui-table --sticky-first-row-and-column xyo-app-table <?php if($this->isEmbedded){echo " --no-border";}; ?>" id="<?php echo $this->instanceV; ?>table">
	<?php include("table-view.sub.php"); ?>
	</table>
	<div class="xyo-app-table --x-5" id="<?php echo $this->instanceV; ?>table-loader"><div class="flex flex-col items-center justify-center xyo-app-table --x-6"><div class="xui-animated-loader"></div></div></div>
	</div>
	<div class="xui-application-toolbar --left --compact">
		<div class="xui-application-toolbar_content">
		<?php
		
		$cssClass=" --medium";
		if($this->isEmbedded){
			$cssClass=" --small ";
		};

		$buttonClass=" --size-xy30";
		if($this->isEmbedded){
			$buttonClass=" --small  --size-xy24-22";
		};

		?>

		<?php $uid=$this->getUID();?>
		<div id="<?php echo $uid; ?>" class="xui-button --transparent xui-effect-ripple --secondary --icon --size-xy30<?php echo $buttonClass; ?> float-left xyo-app-table --x-7"><i class="lucide-chevron-first"></i></div>
		<?php
		$this->ejsBegin();
		echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."go_first=1\");};";
		$this->ejsEnd();
		?>
		<?php $uid=$this->getUID();?>
		<div id="<?php echo $uid; ?>" class="xui-button --transparent xui-effect-ripple --secondary --icon --size-xy30<?php echo $buttonClass; ?> float-left xyo-app-table --x-7"><i class="lucide-chevron-left"></i></div>
		<?php
		$this->ejsBegin();
		echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."go_previous=1\");return false;};";
		$this->ejsEnd();
		?>
		<input class="xui-form-text <?php echo $cssClass; ?> float-left xyo-app-table --x-8 <?php echo ($this->isEmbedded)?" --x-x48":" --x-x64"; ?>" type="text" name="<?php echo $this->instanceV; ?>page" value="<?php echo $page; ?>" size="4" id="<?php echo $this->instanceV; ?>page"></input>
		<?php $uid=$this->getUID();?>
		<div id="<?php echo $uid; ?>" class="xui-button --transparent xui-effect-ripple --secondary --icon --size-xy30<?php echo $buttonClass; ?> float-left xyo-app-table --x-7"><i class="lucide-chevron-right"></i></div>
		<?php
		$this->ejsBegin();
		echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."go_next=1\");return false;};";
		$this->ejsEnd();
		?>
		<?php $uid=$this->getUID();?>
		<div id="<?php echo $uid; ?>" class="xui-button --transparent xui-effect-ripple --secondary --icon --size-xy30<?php echo $buttonClass; ?> float-left xyo-app-table --x-7"><i class="lucide-chevron-last"></i></div>
		<?php
		$this->ejsBegin();
		echo "document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."go_last=1\");return false;};";
		$this->ejsEnd();
		?>

		&nbsp;

		<div class="xui-form-input-group<?php echo $cssClass; ?>">
		        <select name="<?php echo $this->instanceV; ?>count" id="<?php echo $this->instanceV; ?>count"
                		size="1"		                
                		class="xui-form-select --default<?php echo $cssClass; ?>"
				data-xui-select-theme="--default<?php echo $cssClass; ?>"
				data-width="auto" id="<?php echo $this->instanceV; ?>select_count" >
			<?php
			$key = "count";
			foreach ($select_info[$key] as $key_ => $value_) {
				$selected = "";
				if (strcmp($key_, $select_value[$key]) == 0) {
					$selected = " selected=\"selected\"";
				};
				echo "<option value=\"" . $key_ . "\" " . $selected . ">" . $value_ . "</option>";
			};
			?>
		        </select>
			<?php
				if($this->isAjax()) {
					$this->ejsBegin();
					echo "XUI.FormSelect.initById(\"".$this->instanceV."count\");";
					$this->ejsEnd();
				};
				$this->setHtmlJsSourceOrAjax("$(\"#".$this->instanceV."count\").on(\"change\",function(){XYO.Table.doUpdate(\"".$this->instance."\");return false;});","load");
			?>
		</div>

		<?php if(!$this->isInlineForm) { ?>
			<?php if(!$this->isEmbedded){ ?>
			<span class="indicator-items-info xyo-app-table --x-9">
				<?php $this->eLanguage("info.items"); ?> <span class="xyo-app-table --x-10"> - </span> <span id="<?php echo $this->instanceV; ?>page-count"><?php echo $page_count; ?></span> <?php $this->eLanguage("info.pages"); ?> <span class="xyo-app-table -x-10"> - </span> <span id="<?php echo $this->instanceV; ?>item-count"><?php echo $nr_items; ?></span> <?php $this->eLanguage("info.total_items"); ?>
			</span>
			<?php }else{ ?>
			<span class="indicator-items-info text-xui-line xyo-app-table --x-11">
				<span id="<?php echo $this->instanceV; ?>page-count"><?php echo $page_count; ?></span> <?php $this->eLanguage("info.pages"); ?> <span class="xyo-app-table -x-10"> - </span> <span id="<?php echo $this->instanceV; ?>item-count"><?php echo $nr_items; ?></span> <?php $this->eLanguage("info.items"); ?>
			</span>
			<?php }; ?>
		<?php }else{ ?>	
			<span class="indicator-items-info xyo-app-table --x-9">
				<span id="<?php echo $this->instanceV; ?>page-count"><?php echo $page_count; ?></span> / <span id="<?php echo $this->instanceV; ?>item-count"><?php echo $nr_items; ?></span>
			</span>
		<?php }; ?>

		</div>
	</div>
</div>

	<input type="hidden" name="<?php echo $this->instanceV; ?>action" value="table-view" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>primary_key_value" value="0" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>toggle" value="" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>radio" value="" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>order" value="" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>value" value="" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>sort" value="" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>go_first" id="<?php echo $this->instanceV; ?>go_first" value="0" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>go_previous" id="<?php echo $this->instanceV; ?>go_previous" value="0" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>go_next" id="<?php echo $this->instanceV; ?>go_next" value="0" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>go_last" id="<?php echo $this->instanceV; ?>go_last" value="0" />

<?php

if($has_search){ ?>
	<input type="hidden" name="<?php echo $this->instanceV; ?>submit_search" value="" id="<?php echo $this->instanceV; ?>submit_search" />
	<input type="hidden" name="<?php echo $this->instanceV; ?>search_reset" value="" id="<?php echo $this->instanceV; ?>search_reset" />
<?php };

if($this->dialogFilter_){
	foreach ($this->tableSelect as $key => $value) {
		if ($value) {
			echo "<input type=\"hidden\" name=\"".$this->instanceV."view_select_" . $key . "\" id=\"".$this->instanceV."view_select_" . $key . "\" value=\"".$this->getParameterRequestInstance("view_select_" . $key,"*")."\" />";
		};
	};
};

//
if(!$this->isEmbedded){
	$this->eFormRequest();
	echo "</form>";
	if($this->isInlineForm) {
		echo "</div>";
		echo "<div id=\"".$this->instanceV."xyo-app-table-inline-form\" class=\"xyo-app-table --is-inline-form xui-component-table_form\">";
		echo "<div id=\"".$this->instanceV."xyo-app-table-inline\" class=\"xyo-app-table --x-12 xui-overlay-scrollbars\">";
			echo "<div id=\"".$this->instanceV."xyo-app-table-inline_content\">";
			$this->generateView("table-inline-empty");
			$this->setHtmlJsSourceOrAjax("XUI.OverlayScrollbars.create(document.getElementById(\"".$this->instanceV."xyo-app-table-inline\"));","load");
			$this->setHtmlJsSourceOrAjax("\$(\"#xyo-app-table-inline\").show();","load");
			echo "</div>";
		echo "</div>";
	};
};
//

// #New
if($this->isInlineForm){
	$this->generateComponent("xui.inline", array_merge(array(
		"id" => $this->instanceV."xyo-app-table-inline",
		"jsFunction" => $this->instanceV."cmdDialogNew",
		"formSuffix" => "new",
		"action" => "table-inline-new",
		"instance" => $this->instance,
		"noHtml" => true
	),$this->inlineEditParameters_));
}else
if($this->dialogNew_){
	$this->generateComponent($this->dialogComponent["new"], array_merge(array(
		"id" => $this->instanceV."xyo-app-table-modal-new",
		"box" => "1x1",
		"button" => "label.button_new",
		"buttonType" => "primary",
		"jsFunction" => $this->instanceV."cmdDialogNew",
		"formSuffix" => "new",
		"action" => "table-dialog-new",
		"instance" => $this->instance,
	),$this->dialogNewParameters_));
} else {
	$this->ejsBegin();
	echo "window.".$this->instanceV."cmdDialogNew=function(){".$this->instanceV."doCommand(\"form-new\");};";
	$this->ejsEnd();		
};

// #Edit

if($this->isInlineForm){
	$this->generateComponent("xui.inline", array_merge(array(
		"id" => $this->instanceV."xyo-app-table-inline",
		"jsFunction" => $this->instanceV."cmdDialogEditAction",
		"formSuffix" => "edit",
		"action" => "table-inline-edit",
		"instance" => $this->instance,
		"noHtml" => true
	),$this->inlineEditParameters_));
}else
if($this->dialogEdit_){
	$this->generateComponent($this->dialogComponent["edit"], array_merge(array(
		"id" => $this->instanceV."xyo-app-table-modal-edit",
		"box" => "1x1",
		"button" => "label.button_edit",
		"buttonType" => "primary",
		"jsFunction" => $this->instanceV."cmdDialogEditAction",
		"formSuffix" => "edit",
		"action" => "table-dialog-edit",
		"instance" => $this->instance
	),$this->dialogEditParameters_));
} else {
	$this->ejsBegin();
	echo "window.".$this->instanceV."cmdDialogEdit=function(){".$this->instanceV."doCommand(\"form-edit\");};";
	$this->ejsEnd();		
};

if(($this->isInlineForm)||($this->dialogEdit_)){
	$this->setHtmlJsSourceOrAjax(
		"window.".$this->instanceV."cmdDialogEdit=function(pkv){".
        		"var el;".
        		"var id;".
        		"var found=false;".
			"if(typeof pkv != 'undefined'){".
				"id=pkv;".
				"XYO.Table.checkboxOnlyOneById('".$this->instance."',pkv);".
			"}else{".			
			        "id=\"\";".
			        "for(k=1;k<=XYO.Table.instance['".$this->instance."'].id.length; ++k){".
					"el=document.getElementById(\"".$this->instanceV."cbox_\"+k);".
					"if(el){".
						"if(el.checked){".
			        	            "id+=\"\"+XYO.Table.instance['".$this->instance."'].id[k-1];".
			                	    "id+=\",\";".
						    "found=true;".
						    "break;".
						"}".
					"}".
		        	"};".			
				"if(!found){return};".
			"};".
			$this->instanceV."cmdDialogEditAction({".$this->instanceV."primary_key_value: id})".
		"};".
		"\r\n"
	,"load");
};


if(!$this->isEmbedded){
	if($this->isInlineForm){
		echo "</div>";
	};
};

// #Filter

if($this->dialogFilter_){

	$scriptX="";
	if($this->filterHasSearch_) {
		$scriptX.="\$(\"#".$this->instanceV."search\").val(\$(\"#".$this->instanceV."fn_filter_search\").val());";
	};
	foreach ($this->tableSelect as $key => $value) {
		if($value){
			$scriptX.="var filterVal=\$(\"#".$this->instanceV."fn_filter_e_".$key."\").val();";
			$scriptX.="if(filterVal){}else{filterVal=\"*\";};";
			$scriptX.="\$(\"#".$this->instanceV."view_select_".$key."\").val(filterVal);";
		};
	};
	$scriptX.="XUI.Modal.deactivate();";
	$scriptX.="XYO.Table.doUpdate(\"".$this->instance."\");";

	$this->generateComponent($this->dialogComponent["filter"], array_merge(array(
		"id" => $this->instanceV."xyo-app-table-modal-filter",
		"box" => "1x1",
		"button" => "label.button_filter",
		"buttonType" => "primary",
		"jsFunction" => $this->instanceV."cmdDialogFilter",
		"formSuffix" => "filter",			
		"action" => "table-dialog-filter",
		"jsButtonClick" => $scriptX,
		"instance" => $this->instance
	),$this->dialogFilterParameters_));

};

// #Delete

$this->generateComponent($this->dialogComponent["delete"], array(
	"id" => $this->instanceV."xyo-app-table-modal-delete",
	"title-text" => "<span class=\"text-xui-danger-500 xyo-app-table --x-13\"><i class=\"lucide-x xyo-app-table --x-14\"></i>&nbsp;".$this->getFromLanguage("form.title_delete")."</span>",
	"box" => "1x1",
	"button" => "label.button_delete",
	"buttonType" => "danger",
	"hasCancel" => true,
	"jsFunction" => $this->instanceV."cmdDialogDeleteAction",
	"formSuffix" => "delete",
	"action" => "table-dialog-delete",
	"instance" => $this->instance,
	"jsButtonClick" => "XUI.Modal.deactivate();XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."action=table-delete&".$this->instanceV."primary_key_value=\"+XYO.Table.selectId(\"".$this->instance."\"));",
	"jsButtonCancel" => "XUI.Modal.deactivate();"
));

$this->setHtmlJsSourceOrAjax(
	"window.".$this->instanceV."cmdDialogDelete=function(){".
       		"var el;".
       		"var id;".
		"var found=false;".		       
	        "id=\"\";".
	        "for(k=1;k<=XYO.Table.instance['".$this->instance."'].id.length; ++k){".
			"el=document.getElementById(\"".$this->instanceV."cbox_\"+k);".
			"if(el){".
				"if(el.checked){".
		                    "id+=\"\"+XYO.Table.instance['".$this->instance."'].id[k-1];".
		                    "id+=\",\";".
				    "found=true;".
				"}".
			"}".
	        "};".
		"if(!found){return};".
		$this->instanceV."cmdDialogDeleteAction({".$this->instanceV."primary_key_value: id})".
	"};".
	"\r\n"
,"load");

//callActionLink1
foreach($this->tableType as $key_=>$value_){
	if($value_[0]=="action"){
		$p=array();
		foreach($value_[1] as $kk=>$vv){
			$p[$kk]="";
		};
		$request_=$this->requestThisDirect($p);
		$action_=$this->requestUri($this->moduleFromRequestDirect($request_));
		echo "<form name=\"".$this->instanceV."fn_action_".$key_."\" method=\"POST\" action=\"".$action_."\">";
			$this->eFormCsrfToken();
			$this->eFormBuildRequest($request_);
		echo "</form>";		
		$this->ejsBegin();
		echo "window.".$this->instanceV."callActionLink_".$key_."=function(request_){";
		echo " for(var k in request_){";
		echo "  document.forms.".$this->instanceV."fn_action_".$key_.".elements[k].value=request_[k];";
		echo " };";
		echo " document.forms.".$this->instanceV."fn_action_".$key_.".elements[\"csrf_token\"].value=window.csrfToken;";
		echo " document.forms.".$this->instanceV."fn_action_".$key_.".submit();";
		echo "};";			
		$this->ejsEnd();
	};
};

//callActionLink2
foreach($this->tableAction as $key_=>$value_) {
	$p=array();
	foreach($value_ as $kk=>$vv){
		$p[$kk]="";
	};
	$request_=$this->requestThisDirect($p);
	$action_=$this->requestUri($this->moduleFromRequestDirect($request_));
	echo "<form name=\"".$this->instanceV."fn_action_".$key_."\" method=\"POST\" action=\"".$action_."\">";
		$this->eFormCsrfToken();
		$this->eFormBuildRequest($request_);
	echo "</form>";		
	$this->ejsBegin();
	echo "window.".$this->instanceV."callActionLink_".$key_."=function(request_){";
	echo " for(var k in request_){";
	echo "  document.forms.".$this->instanceV."fn_action_".$key_.".elements[k].value=request_[k];";
	echo " };";
	echo " document.forms.".$this->instanceV."fn_action_".$key_.".elements[\"csrf_token\"].value=window.csrfToken;";
	echo " document.forms.".$this->instanceV."fn_action_".$key_.".submit();";
	echo "};";			
	$this->ejsEnd();
};

$this->generateView("table-view-return");
$this->generateView("table-view-call");

include("table-view.instance.php");

if($this->isInlineForm){
	$this->setHtmlJsSourceOrAjax("window.".$this->instanceV."doCommand=function(action){".
	"\$.post(\"".$this->requestUriThis()."\", { ".$this->instanceV."action: \"table-inline-form-command\", ajax: 1, csrf_token: window.csrfToken, csp_nonce: \"".$this->getCSPNonce()."\" })".
	".done(function(response){".		
		"XUI.Script.run(XUI.HTML.extract(response).script,\"".$this->getCSPNonce()."\");".
		"if(".
		"action==\"form-new-apply\"||".
		"action==\"form-edit-apply\"||".
		"action==\"table-new-save\"||".
		"action==\"table-edit-save\"){".
			"return window.doCommandInlineForm(action);".
		"};".
		"if(action==\"table-view\"){".
			$this->generateViewToString("table-inline-toolbar",array("action"=>"table-inline-view-toolbar")).
			"var loader=\"<div class=\\\"xyo-app-table --x-15\\\"><div class=\\\"flex flex-col items-center justify-center xyo-app-table --x-16\\\"><div class=\\\"xui-animated-loader\\\"></div></div></div>\";".
			"\$(\"#xyo-app-table-inline_content\").html(loader);".
			"document.getElementById(\"xyo-application-title\").innerHTML=\"".$this->getApplicationTitle()."\";".
			"\$.post(\"".$this->requestUriThis()."\", { ".$this->instanceV."action: \"table-inline-empty\", ajax: 1, csrf_token: window.csrfToken, csp_nonce: \"".$this->getCSPNonce()."\" })".
	  		".done(function(response){".				
				"XUI.HTML.update(\"xyo-app-table-inline_content\",response,\"".$this->getCSPNonce()."\");".
			"});".
			"return false;".
		"};".
		"return XYO.Table.doCommand(\"".$this->instance."\",action);".		
	"});".
	"return false;".
	"};"
	,"load");
} else {
	$this->setHtmlJsSourceOrAjax("window.".$this->instanceV."doCommand=function(action){ return XYO.Table.doCommand(\"".$this->instance."\",action); };","load");
};

if($this->isEmbedded){
	$this->setHtmlJsSourceOrAjax("XUI.EffectRipple.init();","load");

	if($this->isAjax()){
		$this->setHtmlJsSourceOrAjax("XUI.OverlayScrollbars.create(document.querySelector(\"#".$this->instanceV."component-table .xui-overlay-scrollbars\"));","load");
	};	
};


