<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

include("table-view.init.php");
if(!$this->isInline){
	if($this->isAjax()){
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
	if($this->isInlineForm){ echo "<div class=\"xui xyo-app-table -is-inline-form _table\">"; }; ?>
	<form id="<?php $this->eFormName(); ?>" name="<?php $this->eFormName(); ?>" method="POST" action="<?php $this->eFormAction(); ?>" 
	 class="xyo-app-table_form"
	 onsubmit="XYO.Table.doUpdate('');return false;" >
	 <?php $this->eFormCsrfToken(); ?>
<?php	};

if($this->isInlineForm){
	$this->generateView("table-inline-style-override");
};

$cssClass="-application";
if($this->isEmbedded){
	$cssClass="-no-top-toolbar -no-border-bottom-toolbar -table-border";
};
   
if(($this->hideTopToolbar_)&&(!$this->isInlineForm)){
	$cssClass.=" -hide-secondary-top-toolbar";
};

if($this->isInlineForm){
	$cssClass.=" -is-inline-form";
};

if($this->hideTopToolbar_) {
	$cssClass.=" -hide-top-toolbar";
};

if($this->tableUseApplicationSearch) {
	$cssClass.=" -use-application-search";
};

?>

<div class="xui component-table <?php echo $cssClass;?>">
	<div class="xui app-toolbar"></div>
	<div class="xui app-toolbar -compact -wide">
		<div class="xui _content">
		<?php if($this->isInlineForm && $has_search){ ?>
			<div class="xui form-input-group" style="width:100%;<?php if($this->tableUseApplicationSearch){echo "display:none;";}; ?>">
				<input type="text" name="<?php echo $this->instanceV; ?>search" value="<?php echo $search_value; ?>" size="32" placeholder="<?php $this->eLanguage("search"); ?>" id="<?php echo $this->instanceV; ?>search" class="xyo-app-table_search -inline-form"></input>
				<button type="submit" name="<?php echo $this->instanceV; ?>submit_search" onclick="XYO.Table.doUpdate('<?php echo $this->instance; ?>','&<?php echo $this->instanceV; ?>submit_search=1');return false;"><i class="material-icons">search</i></button>
				<button type="button" name="<?php echo $this->instanceV; ?>search_reset" onclick="XYO.Table.resetSearch('<?php echo $this->instance; ?>',this,'<?php echo $this->instanceV; ?>search');"><i class="material-icons">close</i></button>
			</div>
		<?php } else { ?>
			<div class="xui grid">
				<div class="xui grid -row">
					<div class="xui grid -col -x0">
					<?php if($has_search){ ?>
						<div class="xui form-input-group" <?php if($this->tableUseApplicationSearch){echo "style=\"display:none;\"";}; ?>>
							<input type="text" name="<?php echo $this->instanceV; ?>search" value="<?php echo $search_value; ?>" size="32" placeholder="<?php $this->eLanguage("search"); ?>" id="<?php echo $this->instanceV; ?>search" class="xyo-app-table_search"></input>
							<button type="submit" name="<?php echo $this->instanceV; ?>submit_search" onclick="XYO.Table.doUpdate('<?php echo $this->instance; ?>','&<?php echo $this->instanceV; ?>submit_search=1');return false;"><i class="material-icons">search</i></button>
							<button type="button" name="<?php echo $this->instanceV; ?>search_reset" onclick="XYO.Table.resetSearch('<?php echo $this->instance; ?>',this,'<?php echo $this->instanceV; ?>search');"><i class="material-icons">close</i></button>
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
		<?php }; ?>
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
		        <select name="<?php echo $this->instanceV; ?>count" id="<?php echo $this->instanceV; ?>count"
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
			<?php
				if($this->isAjax()) {
					$this->ejsBegin();
					echo "XUI.FormSelect.initById(\"".$this->instanceV."count\");";
					$this->ejsEnd();					
				};
			?>
		</div>

		<?php if(!$this->isInlineForm) { ?>
			<?php if(!$this->isEmbedded){ ?>
			<span class="xui indicator-items-info" style="font-size: 16px;line-height: 20px;font-weight: normal;margin-left:4px;margin-top: 6px;">
				<?php $this->eLanguage("info.items"); ?> <span style="color: #999;"> - </span> <span id="<?php echo $this->instanceV; ?>page-count"><?php echo $page_count; ?></span> <?php $this->eLanguage("info.pages"); ?> <span style="color: #999;"> - </span> <span id="<?php echo $this->instanceV; ?>item-count"><?php echo $nr_items; ?></span> <?php $this->eLanguage("info.total_items"); ?>
			</span>
			<?php }else{ ?>
			<span class="xui indicator-items-info -fg-aluminium-5" style="font-size: 14px;line-height: 18px;font-weight: normal;margin-left: 6px;margin-top: 3px;">
				<span id="<?php echo $this->instanceV; ?>page-count"><?php echo $page_count; ?></span> <?php $this->eLanguage("info.pages"); ?> <span style="color: #999;"> - </span> <span id="<?php echo $this->instanceV; ?>item-count"><?php echo $nr_items; ?></span> <?php $this->eLanguage("info.items"); ?>
			</span>
			<?php }; ?>
		<?php }else{ ?>	
			<span class="xui indicator-items-info" style="font-size: 16px;line-height: 20px;font-weight: normal;margin-left:4px;margin-top: 6px;">
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
		echo "<div class=\"xui xyo-app-table -is-inline-form _form\">";
		echo "<div id=\"".$this->instanceV."xyo-app-table-inline\" class=\"xui -overlay-scrollbars\" style=\"display:none;height:100%;width:100%;overflow:auto;\">";
			echo "<div id=\"".$this->instanceV."xyo-app-table-inline_content\" class=\"xui\">";
			$this->generateView("table-inline-empty");                         
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
	$this->generateComponent("xui.modal", array_merge(array(
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
	"title-text" => "<span class=\"xui -fg-danger-2\" style=\"line-height: 24px;\"><i class=\"material-icons-outlined\" style=\"float:left\">error_outline</i>&nbsp;".$this->getFromLanguage("form.title_delete")."</span>",
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
	"\$.post(\"".$this->requestUriThis()."\", { ".$this->instanceV."action: \"table-inline-form-command\", ajax: 1, csrf_token: window.csrfToken  })".
	".done(function(result){".
		"var jsAndHtml=XUI.Html.extractScript(result);".		
		"\$(\"#xyo-app-table-inline_content\").append(jsAndHtml.js);".		
		"if(".
		"action==\"form-new-apply\"||".
		"action==\"form-edit-apply\"||".
		"action==\"table-new-save\"||".
		"action==\"table-edit-save\"){".
			"return window.doCommandInlineForm(action);".
		"};".
		"if(action==\"table-view\"){".
			$this->generateViewToString("table-inline-toolbar",array("action"=>"table-inline-view-toolbar")).
			"var loader=\"<div class=\\\"xui\\\" style=\\\"position:relative;width:100%;min-height:240px;\\\"><div class=\\\"xui center-xy\\\" style=\\\"height:240px;\\\"><div class=\\\"xui animated -loader\\\"></div></div></div>\";".
			"\$(\"#xyo-app-table-inline_content\").html(loader);".
			"document.getElementById(\"xyo-application-title\").innerHTML=\"".$this->getApplicationTitle()."\";".
			"\$.post(\"".$this->requestUriThis()."\", { ".$this->instanceV."action: \"table-inline-empty\", ajax: 1, csrf_token: window.csrfToken  })".
	  		".done(function(result){".
				"var jsAndHtml=XUI.Html.extractScript(result);".
				"\$(\"#xyo-app-table-inline_content\").html(jsAndHtml.html);".
				"\$(\"#xyo-app-table-inline_content\").append(jsAndHtml.js);".
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
};

