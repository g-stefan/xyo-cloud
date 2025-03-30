<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_Module extends xyo_Config {

	//
	// Parameters Manager
	//

	protected $parameters;
	protected $parametersStack;

	private function initParametersManager(&$moduleObject) {
		$this->parameters=array();		
		$parametersStack=array();
	}

	public function pushParameters() {
		$this->parametersStack[] = $this->parameters;
	}

	public function popParameters() {
		$this->parameters = array_pop($this->parametersStack);
		if ($this->parameters) {
		} else {
			$this->parameters=array();
		}
	}

	public function mergeParameters($parameters) {
		if (is_null($parameters)) {
			return;
		};
		$this->parameters = array_merge($this->parameters, $parameters);
	}

	public function clearParameters() {
		$this->parameters = array();
	}

	public function setParameter($name, $value) {
		$this->parameters[$name] = $value;
	}

	public function getParameter($name, $default=null) {
		if (array_key_exists($name, $this->parameters)) {
			return $this->parameters[$name];
		}
		return $default;
	}

	public function copyParameter($name, $otherName) {
		if(array_key_exists($otherName,$this->parameters)) {
			$this->parameters[$name] = $this->parameters[$otherName];
		};
	}

	public function getParameterBase($name, $default=null) {
		if (array_key_exists($name, $this->parameters)) {
			return $this->parameters[$name];
		}
		foreach ($this->modulePathBase as $moduleName => $path) {
			$module=&$this->getModule($moduleName);
			if($module->isParameter($name)) {
				return $module->getParameter($name,$default);
			};
		};
		return $default;
	}

	public function isParameter($name) {
		return array_key_exists($name, $this->parameters);
	}

	//
	// Arguments Manager
	//

	protected $arguments;
	protected $argumentsStack;

	private function initArgumentsManager() {
		$this->arguments=array();
		$this->argumentsStack=array();
	}

	public function pushArguments() {
		$this->argumentsStack[] = $this->arguments;
		$this->arguments = array();
	}

	public function popArguments() {
		$this->arguments = array_pop($this->argumentsStack);
		if ($this->arguments) {
		} else {
			$this->arguments=array();
		}
	}

	public function mergeArguments($arguments) {
		if (is_null($arguments)) {
			return;
		};
		$this->arguments = array_merge($this->arguments, $arguments);
	}

	public function setArgument($name, $value) {
		$this->arguments[$name] = $value;
	}

	public function getArgument($name, $default=null) {
		if (array_key_exists($name, $this->arguments)) {
			return $this->arguments[$name];
		}
		return $default;
	}

	//
	// Alert Manager
	//

	protected $alert;
	protected $alertType;

	private function initAlertManager() {
		$this->alert=null;
		$this->alertType=null;
	}

	public function clearAlert() {
		$this->alert=null;
		$this->alertType=null;
	}

	public function isAlert() {
		return !is_null($this->alert);
	}

	public function getAlert($default=null) {
		if (!is_null($this->alert)) {
			return $this->alert;
		};
		return $default;
	}

	public function getAlertType($default=null) {
		if (!is_null($this->alertType)) {
			return $this->alertType;
		};
		return $default;
	}

	public function setAlert($value,$type=null) {
		$this->alert=$value;
		$this->alertType=$type;
	}

	//
	// Error Manager
	//

	protected $error;

	private function initErrorManager() {
		$this->error=null;
	}

	public function clearError() {
		$this->error=null;
	}

	public function isError() {
		return !is_null($this->error);
	}

	public function getError($default=null) {
		if (!is_null($this->error)) {
			return $this->error;
		};
		return $default;
	}

	public function setError($value) {
		$this->error=$value;
	}

	public function isAnyError() {
		return (($this->isError())||($this->isElementError()));
	}

	//
	// Language Manager
	// ISO Language Codes
	//

	protected $language;

	private function initLanguageManager() {
		$this->language=new xyo_Language($this->cloud,$this->name);
	}

	function loadLanguage() {
		$this->loadLanguageDirect($this->cloud->get("language"));
	}

	function loadLanguageDirect($language_) {
		$this->language->setLanguage($language_);
		$language = strtolower($language_);
		foreach (array_reverse($this->modulePathBase, true) as $module => $path) {
			$this->language->includeFile($path . "language/" . $language . ".php");
		}
	}

	function loadLanguageFromPathDirect($path, $language_) {
		$language = strtolower($language_);
		$this->language->setLanguage($language_);
		$this->language->includeFile($path . $language . ".php");
	}

	function loadLanguageFromModuleDirect($module, $language_) {
		$language = strtolower($language_);
		$path = $this->cloud->getModulePath($module);
		if ($path) {
			$this->language->setLanguage($language_);
			$this->language->includeFile($path . "language/" . $language . ".php");
		}
	}

	public function generateViewLanguage($name=null, $arguments=null) {
		if ($this->generateView(strtolower($this->cloud->get("language")) . "/" . $name, $arguments)) {
			return true;
		}
		return $this->generateView($name, $arguments);
	}

	public function isLanguage($name) {
		return $this->language->isLanguage($name);
	}

	public function getSystemLanguage() {
		return $this->cloud->get("language");
	}

	public function getLanguageType() {
		return $this->language->getLanguageType();
	}

	public function isLanguageType($type) {
		return $this->language->isLanguageType($type);
	}

	public function getFromLanguage($name, $default_=null) {
		return $this->language->get($name, $default_);
	}

	public function eLanguage($name, $default_=null) {
		echo $this->language->get($name, $default_);
	}

	//
	//  Form Manager
	//

	protected $formName;
	protected $formNameV;
	protected $elementValue;
	protected $elementPrefix;
	protected $elementPrefixV;
	protected $elementPrefixXV;

	protected $elementAlert;
	protected $elementAlertType;
	protected $elementError;

	private function initFormManager() {
		$this->setFormName("fn");
		$this->setElementPrefix("e");
		$this->clearElementAlert();
		$this->clearElementError();
	}

	public function setFormName($name) {
		if(strlen($name)){
			if(strlen($this->instance)){
				if(strncmp($name, $this->instanceV, strlen($this->instanceV)) === 0){
					$this->formName = $name;
					$this->formNameV = $name . "_";
					return;
				};
			};
			$this->formName = $this->instanceV.$name;
			$this->formNameV = $this->instanceV.$name . "_";
			return;
		};
		$this->formName = "";
		$this->formNameV = "";
	}

	public function getFormName() {
		return $this->formName;
	}

	public function eFormName() {
		echo htmlspecialchars($this->formName);
	}

	public function setElementPrefix($name) {
		if(strlen($name)){
			if(strlen($this->instance)){
				if(strncmp($name, $this->instanceV, strlen($this->instanceV)) === 0){
					$this->elementPrefix = $name;
					$this->elementPrefixV = $name."_";
					$this->elementPrefixXV = $name."_";
					return;
				};
			};
			$this->elementPrefix = $this->instanceV.$name;
			$this->elementPrefixV = $this->instanceV.$name."_";
			$this->elementPrefixXV = $name."_";
			return;
		};
		$this->elementPrefix = "";
		$this->elementPrefixV = "";
		$this->elementPrefixXV = "";
	}

	public function getElementPrefix() {
		return $this->elementPrefix;
	}

	public function clearElementPrefix() {
		$this->elementPrefix = "";
		$this->elementPrefixV = "";
	}

	public function resetElementPrefix() {
		$this->setElementPrefix("e");
	}

	public function getElementName($name) {
		return $this->elementPrefixV.$name;
	}

	public function eElementName($name) {
		echo $this->getElementName($name);
	}

	public function getElementId($name, $postfix=null) {
		return $this->formNameV.$this->elementPrefixXV.$name.($postfix ? "_" . $postfix : "");
	}

	public function eElementId($name, $postfix=null) {
		echo $this->getElementId($name, $postfix);
	}

	public function setElementValue($name, $value) {
		$this->elementValue[$this->elementPrefixV.$name] = $value;
	}

	public function getElementValue($name, $default=null) {
		return $this->cloud->getParameterRequest($this->elementPrefixV.$name, $this->elementValue, $default);
	}

	public function clearElements() {
		$this->elementValue = array();
	}

	public function isElement($name) {
		return $this->cloud->isParameterRequest($this->elementPrefixV.$name, $this->elementValue);
	}

	public function eElementValue($name, $default=null) {
		$value=$this->getElementValue($name, $default);
		if(is_null($value)) {
			$value="";
		};
		echo htmlspecialchars($value);
	}

	public function setElementDefaultValue($name, $default) {
		$this->setElementValue($name,$this->getElementValue($name,$default));
	}

	public function setElementValueIfNotExists($name, $value) {
		if (!array_key_exists($this->elementPrefixV.$name, $this->elementValue)) {
			$this->elementValue[$this->elementPrefixV.$name] = $value;
		}
	}

	public function clearElementAlert($name=null) {
		if(is_null($name)){
			$this->elementAlert=array();
			$this->elementAlertType=array();
			return;
		};
		$this->elementAlert[$this->elementPrefixV.$name]=null;
		$this->elementAlertType[$this->elementPrefixV.$name]=null;
	}

	public function isElementAlert($name=null) {
		if(is_null($name)){
			return count($this->elementAlert)>0;
		};
		if(array_key_exists($this->elementPrefixV.$name,$this->elementAlert)){
			return !is_null($this->elementAlert[$this->elementPrefixV.$name]);
		};
		return false;
	}

	public function setElementAlert($name, $value, $type=null) {
		$this->elementAlert[$this->elementPrefixV.$name]=$value;
		$this->elementAlertType[$this->elementPrefixV.$name]=$type;
	}

	public function getElementAlert($name,$default=null) {
		if(array_key_exists($this->elementPrefixV.$name,$this->elementAlert)){
			if(!is_null($this->elementAlert[$this->elementPrefixV.$name])){
				return $this->elementAlert[$this->elementPrefixV.$name];
			};
		};
		return $default;
	}

	public function getElementAlertType($name,$default=null) {
		if(array_key_exists($this->elementPrefixV.$name,$this->elementAlertType)){
			if(!is_null($this->elementAlertType[$this->elementPrefixV.$name])){
				return $this->elementAlertType[$this->elementPrefixV.$name];
			};
		};
		return $default;
	}

	public function eElementAlert($name, $default=null) {
		echo $this->getElementAlert($name, $default);
	}

	public function clearElementError($name=null) {
		if(is_null($name)){
			$this->elementError=array();
			if($this->isError()){
				if($this->getError()==="element"){
					$this->clearError();
				};
			};
			return;
		};
		$this->elementError[$this->elementPrefixV.$name]=null;
	}

	public function isElementError($name=null) {
		if(is_null($name)){
			return count($this->elementError)>0;
		};
		if(array_key_exists($this->elementPrefixV.$name,$this->elementError)){
			return !is_null($this->elementError[$this->elementPrefixV.$name]);
		};
		return false;
	}

	public function setElementError($name, $value) {
		$this->elementError[$this->elementPrefixV.$name]=$value;
		$this->setError("element");
	}

	public function setElementErrorFromLanguage($name, $value) {
		$this->elementError[$this->elementPrefixV.$name]=$this->getFromLanguage("element.".$value);
		$this->setError("element");
	}

	public function getElementError($name,$default=null) {
		if(array_key_exists($this->elementPrefixV.$name,$this->elementError)){
			if(!is_null($this->elementError[$this->elementPrefixV.$name])){
				return $this->elementError[$this->elementPrefixV.$name];
			};
		};
		return $default;
	}

	public function eElementError($name, $default=null) {
		echo $this->getElementError($name, $default);
	}

	public function getElementValueString($element, $default=null, $size=0) {
		$retV=$this->getElementValue($element,$default);
		if(!is_null($retV)) {
			if($size) {
				return substr(trim($retV),0,$size);
			};
			return trim($retV);
		};
		return null;
	}

	public function getElementValueNumber($element, $default=0, $exDefault="*") {
		$retV = $this->getElementValue($element);
		if($retV) {
			$retV=trim($retV);
			if($exDefault) {
				if($retV===$exDefault) {
					return 1*$default;
				};
			};
			if(is_numeric($retV)) {
				return 1*$retV;
			};
		};
		return 1*$default;
	}

	public function getFormAction($parameters=null) {
		return $this->cloud->requestUriModule($this->name, $parameters);
	}

	public function getFormActionModule($module,$parameters=null) {
		return $this->cloud->requestUriModule($module, $parameters);
	}

	public function getFormActionRoute($requestMain,$parameters=null) {
		return $this->cloud->requestUriRouteModule($requestMain,$this->name, $parameters);
	}

	public function getFormActionRouteModule($requestMain,$module,$parameters=null) {
		return $this->cloud->requestUriRouteModule($requestMain,$module, $parameters);
	}

	public function eFormAction($parameters=null) {
		echo $this->cloud->requestUriModule($this->name, $parameters);
	}

	public function eFormActionModule($module,$parameters=null) {
		echo $this->cloud->requestUriModule($module, $parameters);
	}

	public function eFormActionRoute($requestMain,$parameters=null) {
		echo $this->cloud->requestUriRouteModule($requestMain,$this->name, $parameters);
	}

	public function eFormActionRouteModule($requestMain,$module,$parameters=null) {
		echo $this->cloud->requestUriRouteModule($requestMain,$module, $parameters);
	}

	public function eFormBuildRequest($requestDirect) {
		foreach ($requestDirect as $key => $value) {
			if(is_null($value)) {
				$value = "";
			};
			echo "<input type=\"hidden\" name=\"" . htmlspecialchars($key) . "\" value=\"" . htmlspecialchars($value) . "\">";
		}
	}

	public function eFormRequest($parameters=null) {
		$this->eFormRequestModule($this->name, $this->arrayMerge($this->keepRequest, $parameters));
	}

	public function eFormRequestModule($module, $parameters=null) {
		$this->eFormBuildRequest($this->cloud->requestModuleDirect($module, $parameters));
	}

	//
	// Component Manager
	//

	protected $componentCache;

	public function initComponentManager() {
		$this->componentCache=array();
	}

	public function requireComponent($component) {
		$scan=array();
		if(!is_array ($component)) {
			$component=array($component);
		};
		foreach($component as $value) {
			if(!array_key_exists($value,$this->componentCache)) {
				$scan[]=$value;
			};
		};
		if(count($scan)) {
			foreach($scan as $appComponent) {
				$index=strpos($appComponent,".",0);
				if($index!==false){
					$componentSuper=substr($appComponent,0,$index);
					$componentName=str_replace(".","/",substr($appComponent,$index+1));
					$componentPath=$this->cloud->get("component.".$componentSuper,$componentSuper);
					$componentFileName=$componentPath."/".$componentName;					

					$this->language->includeFile("component/".$componentPath."/language/".strtolower($this->getSystemLanguage())."/".$componentName.".php");
					$this->processComponentX($componentPath."/",".require");
					$componentPathLevel=dirname($componentFileName);
					if(strcmp($componentPathLevel,$componentPath)!=0){
						$this->processComponentX($componentPathLevel."/",".require");
					};
					$this->processComponentX($componentFileName,".require");
					$this->componentCache[$appComponent]=$componentFileName;
					if(file_exists("component/".$componentFileName.".php")) {
						continue;
					};
					die("FATAL: Required component ".$appComponent." not found.");
				};
				$this->language->includeFile("component/language/".strtolower($this->getSystemLanguage())."/".$appComponent.".php");
				$this->processComponentX($appComponent,".require");
				$this->componentCache[$appComponent]=$appComponent;
				if(file_exists("component/".$appComponent.".php")) {
					continue;
				};
				die("FATAL: Required component ".$appComponent." not found.");
			};
		};
	}

	public function processComponent($comType,$arguments=null) {
		if($arguments) {
		} else {
			$arguments=array();
		};
		if(array_key_exists($comType,$this->componentCache)) {
			$this->processComponentX($this->componentCache[$comType],".process",$arguments);
			return;
		};
		die("FATAL: Component ".$comType." not loaded.");
	}

	public function generateComponent($comType,$arguments=null) {
		if($arguments) {
		} else {
			$arguments=array();
		};
		if(array_key_exists($comType,$this->componentCache)) {
			$this->processComponentX($this->componentCache[$comType],"",$arguments);
			return;
		};
		die("FATAL: Component ".$comType." not loaded.");
	}

	public function processComponentX($name,$suffix,$arguments=null) {
		$this->moduleCallList[]=$this->name;
		$this->pushArguments();
		$this->arguments=$arguments;
		if(is_null($this->arguments)) {
			$this->arguments=array();
		};

		$this->viewPath=$this->cloud->getTemplatePath() . "sys/component/";
		$file=$this->viewPath.$name.$suffix.".php";
		if($this->includeFile($file)) {
			$this->popArguments();
			array_pop($this->moduleCallList);
			return true;
		};

		$this->viewPath="component/";
		$file=$this->viewPath.$name.$suffix.".php";
		if($this->includeFile($file)) {
			$this->popArguments();
			array_pop($this->moduleCallList);
			return true;
		};

		$this->popArguments();
		array_pop($this->moduleCallList);
		return false;
	}

	//
	// HTML Manager
	//

	public function setHtmlClass($class) {
		$this->cloud->setHtmlClass($class);
	}

	public function removeHtmlClass($class) {
		$this->cloud->removeHtmlClass($class);
	}

	public function getHtmlClass() {
		$this->cloud->getHtmlClass();
	}

	public function eHtmlClass() {
		$this->cloud->eHtmlClass();
	}

	public function setHtmlBodyClass($class) {
		$this->cloud->setHtmlBodyClass($class);
	}

	public function removeHtmlBodyClass($class) {
		$this->cloud->removeHtmlBodyClass($class);
	}

	public function getHtmlBodyClass() {
		$this->cloud->getHtmlBodyClass();
	}

	public function eHtmlBodyClass() {
		$this->cloud->eHtmlBodyClass();
	}

	public function eHtmlLanguage() {
		$this->cloud->eHtmlLanguage();
	}
	
	public function setHtmlJs($url,$opt="defer") {
		$this->cloud->setHtmlJs($this->name,$url,$opt);
	}

	public function removeHtmlJs($url) {
		$this->cloud->removeHtmlJs($this->name,$url);
	}

	public function removeHtmlJsAll() {
		$this->cloud->removeHtmlJsAll($this->name);
	}

	public function setHtmlJsBefore($moduleOther){
		$this->cloud->setHtmlJsBefore($this->name,$moduleOther);
	}

	public function setHtmlJsAfter($moduleOther){
		$this->cloud->setHtmlJsAfter($this->name,$moduleOther);
	}

	public function eHtmlJs() {
		$this->cloud->eHtmlJs();
	}

	public function setHtmlJsSource($code,$opt="none") {
		$this->cloud->setHtmlJsSource($this->name,$code,$opt);
	}

	public function removeHtmlJsSourceAll() {
		$this->cloud->removeHtmlJsSourceAll($this->name);
	}

	public function setHtmlJsSourceBefore($moduleOther){
		$this->cloud->setHtmlJsSourceBefore($this->name,$moduleOther);
	}

	public function setHtmlJsSourceAfter($moduleOther){
		$this->cloud->setHtmlJsSourceAfter($this->name,$moduleOther);
	}

	public function eHtmlJsSource() {
		$this->cloud->eHtmlJsSource();
	}

	public function setHtmlCss($url) {
		$this->cloud->setHtmlCss($this->name,$url);
	}

	public function removeHtmlCss($url) {
		$this->cloud->removeHtmlCss($this->name,$url);
	}

	public function removeHtmlCssAll() {
		$this->cloud->removeHtmlCssAll($this->name);
	}

	public function setHtmlCssBefore($moduleOther){
		$this->cloud->setHtmlCssBefore($this->name,$moduleOther);
	}

	public function setHtmlCssAfter($moduleOther){
		$this->cloud->setHtmlCssAfter($this->name,$moduleOther);
	}

	public function eHtmlCss() {
		$this->cloud->eHtmlCss();
	}

	public function setHtmlCssSource($code) {
		$this->cloud->setHtmlCssSource($this->name,$code);
	}

	public function removeHtmlCssSourceAll() {
		$this->cloud->removeHtmlCssSourceAll($this->name);
	}

	public function setHtmlCssSourceBefore($moduleOther){
		$this->cloud->setHtmlCssSourceBefore($this->name,$moduleOther);
	}

	public function setHtmlCssSourceAfter($moduleOther){
		$this->cloud->setHtmlCssSourceAfter($this->name,$moduleOther);
	}

	public function eHtmlCssSource() {
		$this->cloud->eHtmlCssSource();
	}

	public function setHtmlTitle($title) {
		$this->cloud->setHtmlTitle($title);
	}

	public function eHtmlTitle() {
		$this->cloud->eHtmlTitle();
	}

	public function setHtmlDescription($description) {
		$this->cloud->setHtmlDescription($description);
	}

	public function eHtmlDescription() {
		$this->cloud->eHtmlDescription();
	}

	public function setHtmlIcon($uri) {
		$this->cloud->setHtmlIcon($uri);
	}

	public function eHtmlIcon() {
		$this->cloud->eHtmlIcon();
	}

	public function setHtmlCssSourceOrAjax($source) {
		$this->cloud->setHtmlCssSourceOrAjax($this->name,$source);
	}

	public function eCssSourceAjax($source) {
		$this->cloud->eCssSourceAjax($source);
	}

	public function setHtmlJsSourceOrAjax($source,$opt="none") {
		$this->cloud->setHtmlJsSourceOrAjax($this->name,$source,$opt);
	}

	public function eJsSourceAjax($source) {
		$this->cloud->eJsSourceAjax($source);
	}

	public function eHtmlStyle() {
		$this->cloud->eHtmlStyle();
	}

	public function eHtmlScript() {
		$this->cloud->eHtmlScript();
	}

	public function setHtmlBefore($module,$moduleOther = null) {
		if(is_null($moduleOther)){
			$this->cloud->setHtmlBefore($this->name,$module);
		}else{
			$this->cloud->setHtmlBefore($module,$moduleOther);
		};
	}

	public function setHtmlAfter($module,$moduleOther = null) {
		if(is_null($moduleOther)){
			$this->cloud->setHtmlAfter($this->name,$module);
		}else{
			$this->cloud->setHtmlAfter($module,$moduleOther);
		};
	}

	//
	// Module Manager
	//

	public function loadModule($module) {
		return $this->cloud->loadModule($module);
	}

	public function requireModule($module) {
		return $this->cloud->requireModule($module);
	}

	public function runModule($module, $parameters=null) {
		return $this->cloud->runModule($module, $parameters);
	}

	public function &getModule($module) {
		return $this->cloud->getModule($module);
	}

	public function getModulePath($module) {
		return $this->cloud->getModulePath($module);
	}

	public function getModulePathBase($module) {
		return $this->cloud->getModulePathBase($module);
	}


	//
	// Group Manager
	//

	public function loadGroup($group) {
		return $this->cloud->loadGroup($group);
	}

	public function runGroup($group, $parameters=null) {
		return $this->cloud->runGroup($group, $parameters);
	}

	public function &getGroup($group) {
		return $this->cloud->getGroup($group);
	}

	//
	// Application Manager
	//

	public function redirectApplication($name,$parameters=null) {
		$this->cloud->redirectApplication($name,$parameters);
	}

	public function processApplication($name,$parameters=null) {
		$this->cloud->processApplication($name,$parameters);
	}

	public function setDefaultApplication($name) {
		$this->cloud->setDefaultApplication($name);
	}

	public function getDefaultApplication() {
		return $this->cloud->getDefaultApplication();
	}

	public function setApplication($module) {
		return $this->cloud->setApplication($module);
	}

	public function isApplication($name) {
		return $this->cloud->isApplication($name);
	}

	public function getApplication() {
		return $this->cloud->getApplication();
	}

	public function hasApplication() {
		return $this->cloud->hasApplication();
	}

	public function generateApplicationView($parameters=null) {
		return $this->cloud->generateApplicationView($parameters);
	}

	//
	// Request Manager
	//

	protected $keepRequest;
	protected $fnCallId;

	private function initRequestManager() {
		$this->keepRequest=array();
		$this->fnCallId=0;
	}

	public function requestUri($parameters=null) {
		return $this->cloud->requestUri($parameters);
	}

	public function requestModuleDirect($module, $parameters=null) {
		return $this->cloud->requestModuleDirect($module, $parameters);
	}

	public function requestUriModule($module, $parameters=null) {
		return $this->cloud->requestUriModule($module, $parameters);
	}

	public function requestUriRouteModule($requestMain,$module, $parameters=null) {
		return $this->cloud->requestUriRouteModule($requestMain,$module, $parameters);
	}

	public function requestThisDirect($parameters=null) {
		return $this->cloud->requestModuleDirect($this->name, $this->arrayMerge($this->keepRequest, $parameters));
	}

	public function requestUriThis($parameters=null) {
		return $this->cloud->requestUriModule($this->name, $this->arrayMerge($this->keepRequest, $parameters));
	}

	public function keepRequest($name) {
		if ($this->cloud->isParameterRequest($name, $this->parameters)) {
			$this->keepRequest[$name] = $this->cloud->getParameterRequest($name, $this->parameters);
		}
	}

	public function keepRequestElement($name) {
		if ($this->cloud->isParameterRequest($this->elementPrefixV.$name, $this->elementValue)) {
			$this->keepRequest[$this->elementPrefixV.$name] = $this->cloud->getParameterRequest($this->elementPrefixV.$name, $this->elementValue);
		}
	}

	public function clearKeepRequest() {
		$this->keepRequest = array();
	}

	public function setKeepRequest($name, $value) {
		$this->keepRequest[$name] = $value;
	}

	public function setKeepRequestElement($name, $value) {
		$this->keepRequest[$this->elementPrefixV.$name] = $value;
	}

	public function unsetKeepRequest($name) {
		if (array_key_exists($name, $this->keepRequest)) {
			unset($this->keepRequest[$name]);
		}
	}

	public function unsetKeepRequestElement($name) {
		if (array_key_exists($this->elementPrefixV.$name, $this->keepRequest)) {
			unset($this->keepRequest[$this->elementPrefixV.$name]);
		}
	}

	public function getKeepRequestDirect($parameters=null) {
		return $this->arrayMerge($this->keepRequest, $parameters);
	}

	public function getRequestDirect() {
		return $this->cloud->getRequestDirect();
	}

	public function setRequestDirect($value) {
		$this->cloud->setRequestDirect($value);
	}

	public function transferKeepRequest($name,$transfer) {
		$this->transferRequest($name,$transfer);
		$this->keepRequest($transfer);
	}

	public function pushRequest($request) {
		return $this->cloud->pushRequest($request);
	}

	public function popRequest($request) {
		return $this->cloud->popRequest($request);
	}

	public function keepRequestStack() {
		$request=$this->cloud->getRequestDirect();
		foreach($request as $key=>$value) {
			if(strncmp($key,"x_",2)==0) {
				$this->keepRequest[$key] = $value;
			};
		};
	}

	public function unsetKeepRequestStack() {
		foreach($this->keepRequest as $key=>$value) {
			if(strncmp($key,"x_",2)==0) {
				unset($this->keepRequest[$key]);
			};
		};
	}

	public function moduleFromRequest($request) {
		return $this->cloud->moduleFromRequest($request);
	}

	public function moduleFromRequestDirect($request) {
		return $this->cloud->moduleFromRequestDirect($request);
	}

	public function callRequest($requestThis,$requestCall=null) {
		return $this->cloud->callRequest($requestThis,$requestCall);
	}

	public function returnRequest($requestThis,$requestReturn=null) {
		return $this->cloud->returnRequest($requestThis,$requestReturn);
	}

	public function getRequestStack($request) {
		return $this->cloud->getRequestStack($request);
	}

	public function hasRequestStack($request) {
		return $this->cloud->hasRequestStack($request);
	}

	public function runRequest($request) {
		return $this->cloud->runRequest($request);
	}

	public function isRequestCall() {
		return $this->hasRequestStack($this->getRequestDirect());
	}

	public function getRequest($name, $default=null) {
		return $this->cloud->getRequest($name, $default);
	}

	public function setRequest($name, $value) {
		return $this->cloud->setRequest($name, $value);
	}

	public function isRequest($name) {
		return $this->cloud->isRequest($name);
	}

	public function transferRequest($name,$transfer) {
		if($this->cloud->isRequest($name)) {
			return;
		}
		if($this->cloud->isRequest($transfer)) {
			$this->cloud->setRequest($name,$this->cloud->getRequest($transfer));
		}
	}

	public function clearRequest() {
		$this->cloud->clearRequest();
	}

	public function mergeRequest($value) {
		$this->cloud->mergeRequest($value);
	}

	public function getParameterRequest($name, $default=null) {
		return $this->cloud->getParameterRequest($name, $this->parameters, $default);
	}

	public function isParameterRequest($name) {
		return $this->cloud->isParameterRequest($name, $this->parameters);
	}

	public function eRequestUri($parameters=null) {
		echo $this->requestUri($parameters);
	}

	public function eGenerateCallRequestJs($requestThis,$module,$request,$functionJs,$processJs) {
		++$this->fnCallId;
		$request_=$this->callRequest(
				  $this->requestThisDirect($requestThis),
				  $this->requestModuleDirect($module,$request)
			  );
		$action_=$this->requestUri($this->moduleFromRequestDirect($request_));
		$fName=$this->instanceV."fn_call_".$this->fnCallId;
		echo "<form name=\"".$fName."\" method=\"POST\" action=\"".$action_."\">";
		$this->eFormCsrfToken();
		$this->eFormBuildRequest($request_);
		echo "</form>";
		$this->ejsBegin();
		echo "function ".$functionJs."(){";
			echo "if(".$processJs."(document.forms.".$fName.")){";
				echo "document.forms.".$fName.".elements.csrf_token.value=window.csrfToken;";
				echo "document.forms.".$fName.".submit();";
			echo "};";
			echo "return false;";
		echo "};";
		$this->ejsEnd();
		return $fName;
	}

	public function isRequestRedirect(){
		return $this->cloud->isRequestRedirect();
	}

	public function getPostRequest($name, $default=null) {
		return $this->cloud->getPostRequest($name, $default);
	}

	//
	// Storage Manager
	//

	public function getStoragePath() {
		return $this->cloud->getStoragePath($this->name);
	}

	public function getStorageFilename($fileName) {
		return $this->cloud->getStorageFilename($this->name,$fileName);
	}

	//
	// Cloud
	//

	public function isAjax() {
		return $this->cloud->isAjax;
	}

	public function isAjaxJs() {
		return $this->cloud->isAjaxJs;
	}

	public function isJson() {
		return $this->cloud->isJson;
	}

	public function logMessage($type, $message) {
		$this->cloud->logMessage($type, $message, $this->name);
	}	

	public function getCloudPath() {
		return $this->cloud->getCloudPath();
	}

	//
	//  Util
	//

	public function arrayMerge($a, $b) {
		if ($b) {
			return array_merge($a, $b);
		};
		return $a;
	}

	public function jsEscape($x) {
		return str_replace(array("'", "\""), array("&#39;", "&#34;"), $x);
	}

	public function ejsBegin() {
		echo "<script".$this->sCSPNonce().">";
	}

	public function ejsEnd() {
		echo "</script>";
	}

	public function ecssBegin() {
		echo "<style".$this->sCSPNonce().">";
	}

	public function ecssEnd() {
		echo "</style>";
	}

	//
	// Instance Manager
	//

	protected $instanceCount;
	protected $defaultInstance;
	protected $instance;
	protected $instanceV;

	public function initInstanceManager(&$moduleObject) {
		$this->instanceCount=0;
		$this->setInstance($this->getParameterRequest("instance",$moduleObject->instance));
		$this->defaultInstance=$moduleObject->defaultInstance;
		$this->keepRequest("instance");
		$this->updateInstance();
	}

	public function setInstance($value) {
		$this->instance=$value;
		if(strlen($this->instance)){
			$this->instanceV=$this->instance."_";
		}else{
			$this->instanceV="";
		};
		$this->setKeepRequest("instance",$value);
	}

	public function getInstance() {
		return $this->instance;
	}

	public function eInstance() {
		echo $this->instance;
	}

	public function isInstance($value) {
		return $this->instance==$value;
	}

	public function setNewInstance() {
		if(!array_key_exists("xyo_instance_id",$_SESSION)){
			$_SESSION["xyo_instance_id"]=0;
		};
		$_SESSION["xyo_instance_id"]=$_SESSION["xyo_instance_id"]+1;
		$this->setInstance("i".$_SESSION["xyo_instance_id"]."_".$this->instanceCount."_".rand());
	}

	public function setDefaultInstance($value) {
		$this->defaultInstance=$value;
	}

	public function updateInstance() {
		if(strlen($this->instance)==0){
			if(strlen($this->defaultInstance)>0){
				$this->setInstance($this->defaultInstance);
			};
		};		
	}

	public function updateInstanceFromParameter() {
		if(strlen($this->instance)==0) {
			$this->setInstance($this->getParameter("instance",""));
		};
	}

	public function getInstanceName($name) {
		return $this->instanceV . $name;
	}

	public function eInstanceName($name) {
		echo $this->getInstanceName($name);
	}

	public function getInstanceId($name, $postfix=null) {
		return $this->instanceV.$name.($postfix ? "_".$postfix : "");
	}

	public function eInstanceId($name, $postfix=null) {
		echo $this->getInstanceId($name, $postfix);
	}

	public function isParameterInstance($name) {
		return array_key_exists($this->instanceV.$name, $this->parameters);
	}

	public function setParameterInstance($name, $value) {
		$this->parameters[$this->instanceV.$name] = $value;
	}

	public function getParameterInstance($name, $default=null) {
		if (array_key_exists($this->instanceV.$name, $this->parameters)) {
			return $this->parameters[$this->instanceV.$name];
		}
		return $default;
	}

	public function isRequestInstance($name) {
		return $this->cloud->isRequest($this->instanceV.$name);
	}

	public function getRequestInstance($name, $default=null) {
		return $this->cloud->getRequest($this->instanceV.$name, $default);
	}

	public function setRequestInstance($name, $value) {
		return $this->cloud->setRequest($this->instanceV.$name, $value);
	}

	public function isParameterRequestInstance($name) {
		return $this->cloud->isParameterRequest($this->instanceV.$name, $this->parameters);
	}

	public function getParameterRequestInstance($name, $default=null) {
		return $this->cloud->getParameterRequest($this->instanceV.$name, $this->parameters, $default);
	}

	public function keepRequestInstance($name) {
		if ($this->cloud->isParameterRequest($this->instanceV . $name, $this->parameters)) {
			$this->keepRequest[$this->instanceV . $name] = $this->cloud->getParameterRequest($this->instanceV . $name, $this->parameters);
		}
	}

	public function setKeepRequestInstance($name, $value) {
		$this->keepRequest[$this->instanceV . $name] = $value;
	}

	public function unsetKeepRequestInstance($name) {
		if (array_key_exists($this->instanceV . $name, $this->keepRequest)) {
			unset($this->keepRequest[$this->instanceV . $name]);
		}
	}

	public function transferRequestInstance($name,$transfer) {
		if($this->cloud->isRequest($this->instanceV.$name)) {
			return;
		}
		if($this->cloud->isRequest($this->instanceV.$transfer)) {
			$this->cloud->setRequest($this->instanceV.$name,$this->cloud->getRequest($this->instanceV.$transfer));
		}
	}


	//
	// Module
	//

	protected $path;
	protected $name;
	protected $returnValue;
	protected $isOk;
	protected $site;
	protected $siteBase;
	protected $moduleBaseClass;
	protected $modulePathBase;
	protected $isEmbedded;	

	private function initModuleCore(&$moduleObject) {
		$this->path=$moduleObject->path;
		$this->name=$moduleObject->module;
		$this->instanceCount=0;		
		$this->returnValue=null;
		$this->isOk=true;
		$this->site=$this->cloud->get("site","");
		$this->siteBase=$this->cloud->get("site_base","");
		$this->moduleBaseClass = $moduleObject->baseClass;
		$this->modulePathBase = $moduleObject->pathBase;
		$this->isEmbedded = false;		
	}

	public function isBase($name) {
		return ($name === $this->moduleBaseClass);
	}

	public function moduleInit() {
		foreach (array_reverse($this->modulePathBase, true) as $module => $path) {
			$this->includeFile($path . "init.php");
		};		
	}

	public function moduleMainRun($parameters=null) {
		$this->pushParameters();
		$this->mergeParameters($parameters);
		$this->instanceCount++;
		$this->returnValue = null;
		$this->moduleMainExtension();
		$this->popParameters();
		return $this->returnValue;
	}

	public function moduleMainExtension() {
		$this->moduleMain();
	}

	public function moduleMain() {
		$file = $this->getBaseFile("application.php");
		if ($file) {
			include($file);
		} else {
			if(!$this->isEmbedded){
				$this->applicationInit();
				$this->applicationAction();
			};
			$this->applicationView();
		}
	}

	public function setIsEmbedded($value) {
		$this->isEmbedded=$value;
	}

	public function getIsEmbedded($value) {
		return $this->isEmbedded;
	}

	public function embeddedApplication($name,$parameters=null) {
		$applicationModule=&$this->getModule($name);
		if($applicationModule) {
			$applicationModule->setIsEmbedded(true);
			$applicationModule->mergeParameters($parameters);
			$applicationModule->updateInstanceFromParameter();
			$applicationModule->applicationInit();				
			$applicationModule->applicationAction();
		};
	}

	public function moduleDisable() {
		$this->isOk = false;
		return $this->cloud->enableModule($this->name, false);
	}

	public function moduleEnable() {
		$this->isOk = true;
		return $this->cloud->enableModule($this->name, true);
	}

	public function getPath() {
		return $this->path;
	}

	public function &getCloud() {
		return $this->cloud;
	}

	public function getName() {
		return $this->name;
	}

	public function isInGroup($group) {
		$group = $this->cloud->getGroup($group);
		if (count($group)) {
			if (in_array($this->name, $group)) {
				return true;
			}
		}
		return false;
	}

	public function getVersion() {
		return $this->cloud->getVersion($this->name);
	}

	public function includeLocal($name) {
		if (file_exists($this->path . $name)) {
			include($this->path . $name);
			return true;
		};
		return false;
	}

	public function eSite() {
		echo $this->site;
	}

	public function getArgumentParameterRequest($name, $default=null) {
		return $this->getArgument($name,$this->cloud->getParameterRequest($name, $this->parameters, $default));
	}

	public function getBasePathOf($file) {
		foreach ($this->modulePathBase as $path) {
			if (file_exists($path . $file)) {
				return $path;
			}
		}
		return null;
	}

	public function getBaseFile($file) {
		foreach ($this->modulePathBase as $path) {
			if (file_exists($path . $file)) {
				return $path . $file;
			}
		}
		return null;
	}

	public function getPathBase($module=null) {
		if($module) {
			if(array_key_exists($module,$this->modulePathBase)) {
				return $this->modulePathBase[$module];
			}
			return null;
		}
		return $this->modulePathBase;
	}

	public function setReturnValue($value) {
		$this->returnValue=$value;
	}

	public function getReturnValue() {
		return $this->returnValue;
	}

	public function setSession($key,$value) {
		$_SESSION["xyo_module_".$this->name."_".$this->instance."_".$key]=$value;
	}

	public function getSession($key,$default=null) {
		$key_="xyo_module_".$this->name."_".$this->instance."_".$key;
		if(array_key_exists($key_,$_SESSION)) {
			return $_SESSION[$key_];
		};
		return $default;
	}

	//
	// Model View Controller
	//

	protected $nameView;
	protected $nameRedirect;
	protected $cancelAction;
	protected $redirectMax;
	protected $defaultAction;
	protected $viewTemplate;
	protected $moduleCallList;
	protected $viewPath;

	private function initModelViewControllerManager() {
		$this->nameView=null;
		$this->nameRedirect=null;
		$this->cancelAction=null;
		$this->redirectMax=8;
		$this->defaultAction=null;
		$this->viewTemplate=null;
		$this->moduleCallList=array();
		$this->viewPath=null;
	}

	public function applicationInit() {
		foreach (array_reverse($this->modulePathBase, true) as $path) {
			$this->includeFile($path . "init-application.php");
		}
	}

	public function applicationPrepare() {
		$template = $this->cloud->getTemplate();
		if ($template) {
			$modTemplate = &$this->cloud->getModule($template);
			if ($modTemplate) {
				$this->keepRequest = $this->arrayMerge($modTemplate->getKeepRequestDirect(), $this->keepRequest);
			}
		}
	}

	public function applicationAction() {
		$this->nameView = null;
		$this->nameRedirect = null;
		$this->cancelAction = false;
		$redirect = 0;
		$action = $this->defaultAction;
		while ($redirect < $this->redirectMax) {
			++$redirect;
			$this->doAction($action);
			if ($this->cancelAction) {
				return;
			}
			if ($this->nameRedirect) {
				$action = $this->nameRedirect;
				$this->nameRedirect = null;
				continue;
			}
			break;
		}
	}

	public function applicationView($arguments=null) {
		if ($this->viewTemplate) {
			$this->generateView($this->viewTemplate,$arguments);
		} else {
			$this->generateView($this->nameView,$arguments);
		}
	}

	public function cancelAction() {
		$this->cancelAction = true;
	}

	public function setRedirectLevels($count) {
		$this->redirectMax = $count;
	}

	public function getRedirectLevels() {
		return $this->redirectMax;
	}

	public function setDefaultAction($name) {
		$this->defaultAction = $name;
	}

	public function getDefaultAction() {
		return $this->defaultAction;
	}

	public function isDefaultAction($action) {
		return (strcmp($this->defaultAction,$action)==0);
	}

	public function setViewTemplate($name) {
		$this->viewTemplate = $name;
	}

	public function getViewTemplate() {
		return $this->viewTemplate;
	}

	public function generateCurrentView($arguments=null) {
		return $this->generateViewFromModule($this->name, $this->nameView, $arguments);
	}

	public function generateView($name=null, $arguments=null) {
		return $this->generateViewFromModule($this->name, $name, $arguments);
	}

	public function processModel($name=null, $arguments=null) {
		return $this->processModelFromModule($this->name, $name, $arguments);
	}

	public function doAction($name=null, $arguments=null) {
		return $this->doActionFromModule($this->name, $name, $arguments);
	}

	protected function getCallBase() {
		if(count($this->moduleCallList)) {
			$module=array_pop($this->moduleCallList);
			$this->moduleCallList[]=$module;
		} else {
			$module=$this->name;
		};
		$base=null;
		$select=false;
		foreach ($this->modulePathBase as $key => $value) {
			if($select) {
				$base=$key;
				break;
			};
			if($key===$module) {
				$select=true;
			};
		};
		return $base;
	}

	public function processModelBase($name=null, $arguments=null) {
		return $this->processModelFromModule($this->getCallBase(), $name, $arguments);
	}

	public function generateViewBase($name=null, $arguments=null) {
		return $this->generateViewFromModule($this->getCallBase(), $name, $arguments);
	}

	public function doActionBase($name=null, $arguments=null) {
		return $this->doActionFromModule($this->getCallBase(), $name, $arguments);
	}

	public function setView($name) {
		$this->nameView = $name;
	}

	public function getView() {
		return $this->nameView;
	}

	public function doRedirect($name) {
		$this->nameRedirect = $name;
	}

	public function getRedirect() {
		return $this->nameRedirect;
	}

	public function generateCurrentViewFromModule($module, $arguments=null) {
		return $this->generateViewFromModule($module, $this->nameView_, $arguments);
	}

	public function generateViewFromModule($module, $name=null, $arguments=null) {

		$this->moduleCallList[]=$module;
		$this->pushArguments();
		$this->arguments=$arguments;

		if(is_null($this->arguments)) {
			$this->arguments=array();
		};

		if (is_null($name)) {
			$name = "default";
		}

		$pathT = $this->cloud->getTemplatePath();
		if ($module === $this->name) {
			foreach ($this->modulePathBase as $moduleName => $path) {
				if ($pathT) {
					$this->viewPath=$pathT . "sys/view/" . $moduleName . "/";
					if ($this->includeFile($pathT . "sys/view/" . $moduleName . "/" . $name . ".php")) {
						$this->popArguments();
						array_pop($this->moduleCallList);
						return true;
					}
				}
				$this->viewPath=$path . "view/";
				if ($this->includeFile($path . "view/" . $name . ".php")) {
					$this->popArguments();
					array_pop($this->moduleCallList);
					return true;
				}
			}
		} else {
			if ($pathT) {
				$this->viewPath=$pathT . "sys/view/" . $module . "/";
				if ($this->includeFile($pathT . "sys/view/" . $module . "/" . $name . ".php")) {
					$this->popArguments();
					array_pop($this->moduleCallList);
					return true;
				}
			}
			$path = $this->cloud->getModulePath($module);
			if ($path) {
				$this->viewPath=$path . "view/";
				if ($this->includeFile($path . "view/" . $name . ".php")) {
					$this->popArguments();
					array_pop($this->moduleCallList);
					return true;
				}
			}
		}

		$this->popArguments();
		array_pop($this->moduleCallList);
		return false;
	}

	public function processModelX($name,$arguments=null) {

		$this->pushArguments();
		$this->arguments=$arguments;
		if(is_null($this->arguments)) {
			$this->arguments=array();
		};

		$file = $this->cloud->getTemplatePath()."sys/model/".$name.".php";
		if($this->includeFile($file)) {
			$this->popArguments();
			return true;
		};

		$this->popArguments();

		return $this->processModel($name,$arguments);
	}

	public function callFromThis($name=null, $arguments=null) {
		return $this->callFromModule($this->name, $name, $arguments);
	}

	public function callFromModule($module, $name=null, $arguments=null) {
		if (is_null($module)) {
			return false;
		};
		$this->moduleCallList[]=$module;
		$this->pushArguments();
		$this->arguments=$arguments;
		if(is_null($this->arguments)) {
			$this->arguments=array();
		};
		if (is_null($name)) {
			array_pop($this->moduleCallList);
			return false;
		};
		if ($module === $this->name) {
			$localSP=0;
			$first=true;			
			foreach ($this->modulePathBase as $key => $path) {
				if(!$first){
					$this->moduleCallList[]=$key;
					++$localSP;
				}else{
					$first=false;
				};
				if ($this->includeFile($path . $name . ".php")) {
					for($k=$localSP; $k>0; --$k) {
						array_pop($this->moduleCallList);
					};
					array_pop($this->moduleCallList);
					$this->popArguments();
					return true;
				};
			};
			for($k=$localSP; $k>0; --$k) {
				array_pop($this->moduleCallList);
			};
		} else {
			$path = $this->cloud->getModulePath($module);
			if ($path) {
				if ($this->includeFile($path . $name . ".php")) {
					array_pop($this->moduleCallList);
					$this->popArguments();
					return true;
				};
			};
		};
		array_pop($this->moduleCallList);
		$this->popArguments();
		return false;
	}

	public function processModelFromModule($module, $name=null, $arguments=null) {
		if(is_null($name)) {
			$name="default";
		};
		return $this->callFromModule($module, "model/".$name, $arguments);
	}

	public function doActionFromModule($module, $name=null, $arguments=null) {
		if(is_null($name)) {
			$name="default";
		};
		return $this->callFromModule($module, "action/".$name, $arguments);
	}

	public function generateViewToString($name=null, $arguments=null) {
		ob_start();			
		$this->generateView($name, $arguments);
		return ob_get_clean();
	}

	//
	// DataSource Manager
	//

	public function &getDataSource($ds) {
		return $this->cloud->dataSource->getDataSource($ds);
	}

	public function setDataSource($name) {
		return $this->cloud->dataSource->setModuleDataSource($this->name, $name);
	}

	//
	// CSRF Mitigation
	//

	public function csrfReset() {
		return ($this->cloud->getCSRFMitigationProvider())->systemCsrfReset();
	}

	public function csrfCheck() {
		return ($this->cloud->getCSRFMitigationProvider())->systemCsrfCheck();
	}

	public function eFormCsrfToken() {
		echo ($this->cloud->getCSRFMitigationProvider())->systemGetFormCsrfToken();
	}

	public function getFormCsrfToken() {
		return ($this->cloud->getCSRFMitigationProvider())->systemGetFormCsrfToken();
	}

	public function setHtmlJsSourceOrAjaxCsrfToken() {
		$this->setHtmlJsSourceOrAjax(($this->cloud->getCSRFMitigationProvider())->systemGetCsrfTokenJsSource(),"load");
	}

	public function getCsrfToken() {
		return ($this->cloud->getCSRFMitigationProvider())->systemGetCsrfToken();
	}

	public function getCsrfTokenJsSource() {
		return ($this->cloud->getCSRFMitigationProvider())->systemGetCsrfTokenJsSource();
	}

	public function setCsrfReferenceCount($count) {
		($this->cloud->getCSRFMitigationProvider())->systemSetCsrfReferenceCount($count);
	}

	//
	// Content Security Policy
	//

	public function setCSPHeader($value) {
		$this->cloud->setCSPHeader($value);
	}

	public function getCSPHeader() {
		return $this->cloud->getCSPHeader();
	}

	public function setCSPNonce($value) {
		$this->cloud->setCSPNonce($value);
	}

	public function getCSPNonce() {
		return $this->cloud->getCSPNonce();
	}

	public function sCSPNonce() {
		return $this->cloud->sCSPNonce();
	}

	//
	// Unique Identifier
	//

	public function getUID() {
		return $this->cloud->getUID();
	}	

	//
	// Constructor
	//

	public function __construct(&$moduleObject, &$cloud) {
		parent::__construct($cloud);
		$this->initModuleCore($moduleObject);
		$this->initParametersManager($moduleObject);
		$this->initInstanceManager($moduleObject);
		$this->initArgumentsManager();
		$this->initAlertManager();
		$this->initErrorManager();
		$this->initLanguageManager();
		$this->initFormManager();
		$this->initComponentManager();
		$this->initRequestManager();
		$this->initModelViewControllerManager();
	}
}

