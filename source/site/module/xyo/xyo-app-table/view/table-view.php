<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

include("table-view.init.php");
if($this->isAjax()){
	require_once("table-view.sub.php");
	include("table-view.instance.php");
	$this->ejsBegin();
	echo "document.getElementById(\"".$this->instanceV."page\").value=\"".$page."\";";
	echo "document.getElementById(\"".$this->instanceV."page-count\").innerHTML=\"".$page_count."\";";
	echo "document.getElementById(\"".$this->instanceV."item-count\").innerHTML=\"".$nr_items."\";";
	$this->ejsEnd();
	return;
};

?>

<?php if(!$this->isEmbedded){ ?>
<form id="<?php $this->eFormName(); ?>" name="<?php $this->eFormName(); ?>" method="POST" action="<?php $this->eFormAction(); ?>" style="width:100%;height:100%;position:relative;margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;overflow:hidden;">
<?php }; ?>

<?php 

$cssClass="-application";
if($this->isEmbedded){
	$cssClass="-no-top-toolbar -no-border-bottom-toolbar -table-border";
};

if($this->hideTopToolbar_){
	$cssClass.=" -hide-secondary-top-toolbar";
};

?>

<div class="xui component-table <?php echo $cssClass;?>">
	<div class="xui app-toolbar"></div>
	<div class="xui app-toolbar -compact -wide">
		<div class="xui _content">
			<div class="xui grid">
				<div class="xui grid -row">
					<div class="xui grid -col -x0">
					<?php if($has_search){ ?>
						<div class="xui form-input-group">
							<input type="text" name="<?php echo $this->instanceV; ?>search" value="<?php echo $search_value; ?>" size="32" style="width:196px" placeholder="<?php $this->eLanguage("search"); ?>" id="<?php echo $this->instanceV; ?>search"></input>
							<button type="submit" name="<?php echo $this->instanceV; ?>submit_search" onclick="XYO.Table.doUpdate('<?php echo $this->instance; ?>','&<?php echo $this->instanceV; ?>submit_search=1');return false;"><i class="material-icons">search</i></button>
							<button type="button" name="<?php echo $this->instanceV; ?>search_reset" onclick="XYO.Table.clearSearch('<?php echo $this->instance; ?>',this,'<?php echo $this->instanceV; ?>search');"><i class="material-icons">close</i></button>
						</div>
				        <?php }; ?>
					</div>
					<div class="xui grid -col -x0">
					<?php if($this->dialogFilter_){ ?>
						<div class="xui -right">
						<div class="xui button -small -transparent -effect-ripple -info -icon-left -toolbar" onclick="<?php echo $this->instanceV; ?>cmdDialogFilter();">
							<i class="material-icons">filter_list</i>				
							<span><?php $this->eLanguage("label.filter"); ?></span>
						</div>
						</div>
					<?php } else {

	       				foreach (array_reverse($this->tableSelect,true) as $key => $value) {
							if ($value) { ?>
							<div class="xui -right" style="margin-left: 4px;">
							<select name="<?php echo $this->instanceV; ?>view_select_<?php echo $key; ?>"
								size="1"
								onChange="XYO.Table.doUpdate('<?php echo $this->instance; ?>');"
								class="xui form-select" id="<?php echo $this->instanceV; ?>view_select_<?php echo $key; ?>" style="margin-left:6px;"
								data-xui-select-theme="-default"><?php
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
			</div>
		</div>
	</div>
	<div class="xui _table -overlay-scrollbars">
        <table class="xui table -sticky-first-row-and-column xyo-app-table <?php if($this->isEmbedded){echo " -no-border";}; ?>" id="<?php echo $this->instanceV; ?>table">
	<?php include("table-view.sub.php"); ?>
	</table>
	<div class="xui" id="<?php echo $this->instanceV; ?>table-loader" style="display:none;position:absolute;top:0px;left:0px;bottom:0px;right:0px;z-index:100;background-color:rgba(128,128,128,0.2);backdrop-filter:blur(3px);"><div class="xui center-xy" style="height:100%;min-height:128px;"><div class="xui animated -loader"></div></div></div>
	</div>
	<div class="xui app-toolbar -left -compact">
		<div class="xui _content">
		<?php
		
		$cssClass=" -medium";
		if($this->isEmbedded){
			$cssClass=" -small";
		};

		$buttonClass=" -size-xy30";
		if($this->isEmbedded){
			$buttonClass=" -small -size-xy24-22";
		};

		?>

		<div class="xui button -transparent -effect-ripple -secondary -icon -size-xy30<?php echo $buttonClass; ?> -left" style="margin-right:0;margin-left:0;" onclick="XYO.Table.doUpdate('<?php echo $this->instance; ?>','&<?php echo $this->instanceV; ?>go_first=1');"><i class="material-icons">first_page</i></div>
		<div class="xui button -transparent -effect-ripple -secondary -icon -size-xy30<?php echo $buttonClass; ?> -left" style="margin-right:0;margin-left:0;" onclick="XYO.Table.doUpdate('<?php echo $this->instance; ?>','&<?php echo $this->instanceV; ?>go_previous=1');return false;"><i class="material-icons">chevron_left</i></div>
		<input class="xui form-text <?php echo $cssClass; ?> -left" type="text" name="<?php echo $this->instanceV; ?>page" style="margin-right:3px;margin-left:3px;width:<?php echo ($this->isEmbedded)?48:64; ?>px;" value="<?php echo $page; ?>" size="4" id="<?php echo $this->instanceV; ?>page"></input>
		<div class="xui button -transparent -effect-ripple -secondary -icon -size-xy30<?php echo $buttonClass; ?> -left" style="margin-right:0;margin-left:0;" onclick="XYO.Table.doUpdate('<?php echo $this->instance; ?>','&<?php echo $this->instanceV; ?>go_next=1');return false;"><i class="material-icons">chevron_right</i></div>
		<div class="xui button -transparent -effect-ripple -secondary -icon -size-xy30<?php echo $buttonClass; ?> -left" style="margin-right:0;margin-left:0;" onclick="XYO.Table.doUpdate('<?php echo $this->instance; ?>','&<?php echo $this->instanceV; ?>go_last=1');return false;"><i class="material-icons">last_page</i></div>

		&nbsp;

		<div class="xui form-input-group<?php echo $cssClass; ?>">
		        <select name="<?php echo $this->instanceV; ?>count"
                		size="1"
		                onChange="XYO.Table.doUpdate('<?php echo $this->instance; ?>');"
                		class="xui form-select -default<?php echo $cssClass; ?>"
				data-xui-select-theme="-default<?php echo $cssClass; ?>"
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
		</div>

		<?php if(!$this->isEmbedded){ ?>
		<span class="xui indicator-items-info" style="font-size: 16px;line-height: 20px;font-weight: normal;margin-left:4px;margin-top: 6px;">
			<?php $this->eLanguage("info.items"); ?> <span style="color: #999;"> - </span> <span id="<?php echo $this->instanceV; ?>page-count"><?php echo $page_count; ?></span> <?php $this->eLanguage("info.pages"); ?> <span style="color: #999;"> - </span> <span id="<?php echo $this->instanceV; ?>item-count"><?php echo $nr_items; ?></span> <?php $this->eLanguage("info.total_items"); ?>
		</span>
		<?php }else{ ?>
		<span class="xui indicator-items-info -fg-aluminium-5" style="font-size: 14px;line-height: 18px;font-weight: normal;margin-left: 6px;margin-top: 3px;">
			<span id="<?php echo $this->instanceV; ?>page-count"><?php echo $page_count; ?></span> <?php $this->eLanguage("info.pages"); ?> <span style="color: #999;"> - </span> <span id="<?php echo $this->instanceV; ?>item-count"><?php echo $nr_items; ?></span> <?php $this->eLanguage("info.items"); ?>
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
};
//

// #New

if($this->dialogNew_){
	$this->generateComponent("xui.modal", array_merge(array(
		"id" => $this->instanceV."xyo-app-table-modal-new",
		"box" => "1x1",
		"button" => "label.button_new",
		"buttonType" => "primary",
		"jsFunction" => $this->instanceV."cmdDialogNew",
		"formSuffix" => "new",
		"action" => "table-dialog-new",
		"instance" => $this->instance
	),$this->dialogNewParameters_));
} else {
	$this->ejsBegin();
	echo "function ".$this->instanceV."cmdDialogNew(){".$this->instanceV."doCommand(\"form-new\");};";
	$this->ejsEnd();		
};

// #Edit

if($this->dialogEdit_){
	$this->generateComponent("xui.modal", array_merge(array(
		"id" => $this->instanceV."xyo-app-table-modal-edit",
		"box" => "1x1",
		"button" => "label.button_edit",
		"buttonType" => "primary",
		"jsFunction" => $this->instanceV."cmdDialogEditAction",
		"formSuffix" => "edit",
		"action" => "table-dialog-edit",
		"instance" => $this->instance
	),$this->dialogEditParameters_));

	$this->setHtmlJsSource(
		"function ".$this->instanceV."cmdDialogEdit(pkv){".
        		"var el;".
        		"var id;".
        		"var found=false;".
			"if(typeof pkv != 'undefined'){".
				"id=pkv;".
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
	);
} else {
	$this->ejsBegin();
	echo "function ".$this->instanceV."cmdDialogEdit(){".$this->instanceV."doCommand(\"form-edit\");};";
	$this->ejsEnd();		
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
	$scriptX.="XUI.Modal.dezactivate();";
	$scriptX.="XYO.Table.doUpdate(\"".$this->instance."\");";

	$this->generateComponent("xui.modal", array_merge(array(
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

$this->generateComponent("xui.modal", array(
	"id" => $this->instanceV."xyo-app-table-modal-delete",
	"title" => "form.title_delete",
	"box" => "1x1",
	"button" => "label.button_delete",
	"buttonType" => "danger",
	"hasCancel" => true,
	"jsFunction" => $this->instanceV."cmdDialogDeleteAction",
	"formSuffix" => "delete",
	"action" => "table-dialog-delete",
	"instance" => $this->instance,
	"jsButtonClick" => "XUI.Modal.dezactivate();XYO.Table.doUpdate(\"".$this->instance."\",\"&".$this->instanceV."action=table-delete&".$this->instanceV."primary_key_value=\"+XYO.Table.selectId(\"".$this->instance."\"));",
	"jsButtonCancel" => "XUI.Modal.dezactivate();"
));

$this->setHtmlJsSource(
	"function ".$this->instanceV."cmdDialogDelete(){".
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
);

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
			$this->eFormBuildRequest($request_);
		echo "</form>";		
		$this->ejsBegin();
		echo "function ".$this->instanceV."callActionLink_".$key_."(request_){";
		echo " for(var k in request_){";
		echo "  document.forms.".$this->instanceV."fn_action_".$key_.".elements[k].value=request_[k];";
		echo " };";
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
		$this->eFormBuildRequest($request_);
	echo "</form>";		
	$this->ejsBegin();
	echo "function ".$this->instanceV."callActionLink_".$key_."(request_){";
	echo " for(var k in request_){";
	echo "  document.forms.".$this->instanceV."fn_action_".$key_.".elements[k].value=request_[k];";
	echo " };";
	echo " document.forms.".$this->instanceV."fn_action_".$key_.".submit();";
	echo "};";			
	$this->ejsEnd();
};

$this->generateView("table-view-return");
$this->generateView("table-view-call");

include("table-view.instance.php");

$this->setHtmlJsSource("function ".$this->instanceV."doCommand(action){ return XYO.Table.doCommand(\"".$this->instance."\",action); };");
