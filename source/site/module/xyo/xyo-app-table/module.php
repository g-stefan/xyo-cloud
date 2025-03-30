<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className = "xyo_app_Table";

class xyo_app_Table extends xyo_app_Application {

	protected $tableComPath;
//---
	protected $tableHead;
	protected $tableSearch;
	protected $tableSelect;
	protected $tableSort;        
	protected $tableSelectInfo;
	protected $tableData;
	protected $tableType; 
	protected $tableDelete;
	protected $tableImportant;
	protected $tableAction;
//---
	protected $viewData;
//---
	protected $viewKey;
	protected $viewId;
	protected $viewPrimaryKey;
	protected $viewValue;
	protected $viewRow;

//---
	protected $tableIsDelete;
//
	protected $dialogNew_;
	protected $dialogNewParameters_;
	protected $dialogEdit_;
	protected $dialogEditParameters_;
	protected $dialogFilter_;
	protected $dialogFilterParameters_;

//
	protected $childInstance;
	protected $childInstanceV;
//
	protected $hideTopToolbar_;
	protected $filterHasSearch_;
	protected $filterToolbarButton_;
//
	protected $hasDynamicRow_;
//
	protected $inlineNew_;
	protected $inlineNewParameters_;
	protected $inlineEdit_;
	protected $inlineEditParameters_;
	protected $isInlineForm;
//
	protected $tableInView;
	protected $tableUseApplicationSearch;

//
	protected $tableIsEmbeddedDialog;
	protected $embeddedDialogStep;

//
	protected $dialogComponent;

	public function __construct(&$object, &$cloud) {
		parent::__construct($object, $cloud);

	        $this->tableComPath = $this->getModulePath("xyo-app-table");

        	$this->tableHead = array();
	        $this->tableSearch = array();
	        $this->tableSelect = array();        
	        $this->tableSort = array();
	        $this->tableSelectInfo = array();             
		$this->tableData = array();

	        $this->tableType = array();
	        $this->tableDelete = array();
		$this->tableImportant = array();
		
		$this->tableAction = array();

	        $this->viewData = null;
		$this->viewKey=null;
		$this->viewId=0;
		$this->viewPrimaryKey=0;
		$this->viewValue=null;
		$this->viewRow=null;

		$this->tableIsDelete=false;
		$this->dialogNew_=false;
		$this->dialogNewParameters_=array();
		$this->dialogEdit_=false;
		$this->dialogEditParameters_=array();
		$this->dialogFilter_=false;
		$this->dialogFilterParameters_=array();

		$this->childInstance="";
		$this->childInstanceV="";

		$this->hideTopToolbar_=false;
		$this->filterHasSearch_=false;
		$this->filterToolbarButton_=false;

		$this->hasDynamicRow_=false;

		$this->inlineNew_=false;
		$this->inlineNewParameters_=array();
		$this->inlineEdit_=false;
		$this->inlineEditParameters_=array();
		$this->isInlineForm=false;

		$this->tableInView=false;
		if(!$this->isEmbedded) {
			$this->tableUseApplicationSearch=true;
			$this->hasFilterToolbar(true);
		};

		$this->tableIsEmbeddedDialog=false;
		$this->embeddedDialogStep=0;

		$this->dialogComponent=array(
			"new"=>"xui.modal",
			"delete"=>"xui.modal",
			"edit"=>"xui.modal",
			"filter"=>"xui.modal"
		);
	}

	public function applicationInit() {

		$this->isInline=$this->getParameter("is_inline",$this->isInline);

		parent::applicationInit();
	}	

	public function viewKeepRequest(){
		$this->transferRequestInstance("page","view_page");
		$this->keepRequestInstance("view_page");

		$this->transferRequestInstance("count","view_count");
		$this->keepRequestInstance("view_count");

		foreach($this->getRequestDirect() as $key=>$value){
			if(strncmp($key,$this->instanceV."view_select_",strlen($this->instanceV)+12)==0){
				$this->setKeepRequest($this->instanceV."view_x_select_".substr($key,strlen($this->instanceV)+12),$value);
			}
			if(strncmp($key,$this->instanceV."view_x_select_",strlen($this->instanceV)+14)==0){
				$this->transferRequest($this->instanceV."view_select_".substr($key,strlen($this->instanceV)+14),$this->instanceV."view_x_select_".substr($key,strlen($this->instanceV)+14));
				$this->keepRequest($this->instanceV."view_select_".substr($key,strlen($this->instanceV)+14));
			}
			if(strncmp($key,$this->instanceV."sort_v_",strlen($this->instanceV)+7)==0){
				$this->setKeepRequest($this->instanceV."view_x_sort_v_".substr($key,strlen($this->instanceV)+7),$value);
			}
			if(strncmp($key,$this->instanceV."view_x_sort_v_",strlen($this->instanceV)+14)==0){
				$this->transferRequest($this->instanceV."sort_v_".substr($key,strlen($this->instanceV)+14),$this->instanceV."view_x_sort_v_".substr($key,strlen($this->instanceV)+14));
			}
			if(strncmp($key,$this->instanceV."search",strlen($this->instanceV)+6)==0){
				$this->setKeepRequest($this->instanceV."view_x_search",$value);
	        	}
			if(strncmp($key,$this->instanceV."view_x_search",strlen($this->instanceV)+13)==0){
				$this->transferRequest($this->instanceV."search",$this->instanceV."view_x_search");
			}                
			if(strncmp($key,$this->instanceV."search_reset",strlen($this->instanceV)+12)==0){
				$this->setKeepRequest($this->instanceV."view_x_search_reset",$value);
			}
			if(strncmp($key,$this->instanceV."view_x_search_reset",strlen($this->instanceV)+19)==0){
				$this->transferRequest($this->instanceV."search_reset",$this->instanceV."view_x_search_reset");
			}
			
		}
	}

	public function selectEditRequest(){
		foreach($this->getRequestDirect() as $key=>$value){
			if(strncmp($key,$this->instanceV."edit_select_",strlen($this->instanceV)+12)==0){
				$this->setElementValue(substr($key,strlen($this->instanceV)+12),$value);
			}
		}
	}

	public function eGenerateCallRequest($requestThis,$module,$request,$selector,$functionJs){
		$pJs="function(form_){".
			"var id;".
			"id=XYO.Table.selectIdOne(\"".$this->instance."\");".
			"if(id){".
			"form_.".$selector.".value=id;".
				"return true;".
			"};".
			"return false;".
		"}";
		return $this->eGenerateCallRequestJs($requestThis,$module,$request,$functionJs,$pJs);
	}

	public function setDialogNew($value, $parameters = array()){
		$this->dialogNew_=$value;
		$this->dialogNewParameters_=$parameters;
	}

	public function setDialogEdit($value, $parameters = array()){
		$this->dialogEdit_=$value;
		$this->dialogEditParameters_=$parameters;
	}

	public function setDialogFilter($value, $parameters = array()){
		$this->dialogFilter_=$value;
		$this->dialogFilterParameters_=$parameters;
	}

	public function setInlineNew($value, $parameters = array()){
		$this->inlineNew_=$value;
		$this->inlineNewParameters_=$parameters;
		$this->isInlineForm=true;
	}

	public function setInlineEdit($value, $parameters = array()){
		$this->inlineEdit_=$value;
		$this->inlineEditParameters_=$parameters;
		$this->isInlineForm=true;
	}

	public function allowEmbedding(){
		$this->setInstance($this->getParameterRequest("instance", ""));
		$this->setIsEmbedded($this->getParameterRequest("is_embedded", false));
		$this->setIsDialog($this->getParameterRequest("is_dialog", false));
		$this->setDefaultAction($this->getRequestInstance("action", "table-view"));

		if($this->isEmbedded){
			$this->setKeepRequest("is_embedded",$this->isEmbedded);
		};		

		if($this->isDialog){
			$this->setKeepRequest("is_dialog",$this->isDialog);
		};

		if($this->isDialog){
			$this->setDialogNew(true);
			$this->setDialogEdit(true);			
		};
	}

	public function setChildInstance($childInstance){
		$this->childInstance=$childInstance;
		$this->childInstanceV=$childInstance."_";
		$this->setHtmlJsSourceOrAjax("XYO.Table.parentInstance[\"".$this->childInstance."\"]={instance:\"".$this->instance."\",form:document.forms.".$this->getFormName()."};","load");
	}

	public function setHideTopToolbar($value){
		$this->hideTopToolbar_ = $value;
	}

	public function setFilterHasSearch($value){
		$this->filterHasSearch_=$value;
	}

	public function setFilterToolbarButton($value){
		$this->filterToolbarButton_ = $value;

		$this->toolbarParameter=array_merge($this->toolbarParameter,array("filter_toolbar_button"=>$this->filterToolbarButton_));
	}

	public function hasFilterToolbar($value){
		$this->setHideTopToolbar($value);
		$this->setDialogFilter($value);
		$this->setFilterHasSearch($value);
		$this->setFilterToolbarButton($value);
	}

	public function hasDynamicRow($value){
		$this->hasDynamicRow_=$value;
	}
	                                    
	public function setInlineForm($value) {
		$this->setInlineNew($value);
		$this->setInlineEdit($value);
		$this->hasFilterToolbar($value);
	}

	public function hasSearch() {
		if($this->tableUseApplicationSearch) {
			if($this->tableInView) {
				return true;
			};
		};
		return false;
	}

	public function useApplicationSearch($value) {
		$this->tableUseApplicationSearch = $value;
	}

	public function getCmdEditLink($index) {
		return $this->requestUriThis(array("action"=>"form-edit","primary_key_value"=>$this->viewData[$index][$this->primaryKey]));
	}

	public function getCmdEditOnClick($key,$index) {
		if($this->dialogEdit_){
			return $this->instanceV."cmdDialogEdit('".$this->viewData[$index][$this->primaryKey]."');return false;";
		};
		if($this->inlineEdit_){
			return $this->instanceV."cmdDialogEdit('".$this->viewData[$index][$this->primaryKey]."');return false;";
		};
		return $this->instanceV."callActionLink_".$key."({'action':'form-edit','primary_key_value':'".$this->viewData[$index][$this->primaryKey]."'});return false;";
	}

	public function isEmbeddedDialog($value){
		$this->tableIsEmbeddedDialog=$value;
		$this->embeddedDialogStep=$this->getParameterRequest("is_embedded_dialog", 2);
		if($this->embeddedDialogStep>0){
			--$this->embeddedDialogStep;
		};
		$this->setKeepRequest("is_embedded_dialog",$this->isEmbedded);
	}

	public function setDialogComponent($type,$value){
		$this->dialogComponent[$type]=$value;
	}
	
}
