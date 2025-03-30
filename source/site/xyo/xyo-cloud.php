<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

//
// XYO Cloud
//
// - Implements: Content-Based Router
// - Becomes: Model View Presenter / Controller / Supervising Controller or
// anything else
// - Module management, by contract
//

define("XYO_CLOUD", 1);
$xyo_Path = dirname(realpath(__FILE__)) . "/";
require_once($xyo_Path . "xyo-attributes.php");
require_once($xyo_Path . "xyo-config.php");
require_once($xyo_Path . "xyo-request.1.php");
require_once($xyo_Path . "xyo-language.php");
require_once($xyo_Path . "xyo-module.php");
require_once($xyo_Path . "xyo-datasource.php");

class xyo_ModuleObject {
	public  $parent;
	public  $module;
	public  $className;
	public  $enabled;
	public  $path;
	public  $init;
	public  $loaded;
	public  $check;	
	public  $application;
	public  $baseClass;
	public  $pathBase;
	public  $registered;
	public  $object;
	public  $instance;
	public  $defaultInstance;
}

class xyo_Cloud extends xyo_Config {

	//
	// Module Manager
	//

	protected $moduleList;
	protected $moduleLoader;
	protected $referenceBase;
	protected $referenceLinks;

	protected function initModuleManager() {
		$this->moduleLoader = null;
		$this->moduleList = array();
		$this->referenceBase = array();
		$this->referenceLinks = array();
	}

	public function setModuleLoader($name) {
		$this->moduleLoader = &$this->getModule($name);
	}

	public function runModule($module, $parameters=null) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			if ($moduleObject->enabled) {
				if (!$moduleObject->loaded) {
					if ($this->loadModule($moduleObject->module)) {

					} else {
						return null;
					};
				};
				return $moduleObject->object->moduleMainRun($parameters);
			};
		};
		return null;
	}

	public function &getModuleObject($module) {
		$rValue = null;
		if (strlen($module) == 0) {
			return $rValue;
		};

		if (array_key_exists($module, $this->moduleList)) {
			if (!$this->moduleList[$module]->check) {
				return $this->moduleList[$module];
			};
		};

		if ($this->moduleLoader) {
			if ($this->moduleLoader->systemSetModule($module)) {
				if (array_key_exists($module, $this->moduleList)) {
					$this->moduleList[$module]->check = false;
					return $this->moduleList[$module];
				};
			};
		};

		if (array_key_exists($module, $this->moduleList)) {
			if ($this->moduleList[$module]->check) {
				$this->moduleList[$module]->check = false;
				$this->moduleList[$module]->enabled = false;
			};
			return $this->moduleList[$module];
		};

		return $rValue;
	}

	public function &getModule($module) {
		$rValue = null;
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			if ($moduleObject->enabled) {
				if (!$moduleObject->loaded) {
					if (!$this->loadModule($moduleObject->module)) {
						return $rValue;
					};
				};
				return $moduleObject->object;
			};
		};
		return $rValue;
	}

	public function enableModule($module, $enable=true) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleObject->enabled = $enable;
			return true;
		};
		return false;
	}

	public function disableModule($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleObject->enabled = false;
			return true;
		};
		return false;
	}

	public function getModulePath($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			return $moduleObject->path;
		};
		return null;
	}

	public function getModulePathBase($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			return $moduleObject->pathBase;
		};
		return null;
	}

	public function initModule($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {

			if ($moduleObject->loaded) {
				return true;
			};

			if ($moduleObject->init) {
				return true;
			};

			$initFile = $moduleObject->path . "cloud.php";
			if (file_exists($initFile)) {
				require_once($initFile);
			};

			$moduleObject->pathBase = array($module => $moduleObject->path);
			$moduleBase = $module;
			while (array_key_exists($moduleBase, $this->referenceBase)) {
				$moduleBase = $this->referenceBase[$moduleBase];
				$this->initModule($moduleBase);
				$base = &$this->getModuleObject($moduleBase);
				if ($base) {
					$moduleObject->pathBase[$moduleBase] = $base->path;
				};
			};

			$moduleObject->init = true;
			return true;

		};
		return false;
	}

	public function loadModule($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {

			if (!$moduleObject->enabled) {
				return false;
			};

			if ($moduleObject->loaded) {
				return true;
			};

			if (!$moduleObject->init) {
				$this->initModule($module);
			};			

			if (!$this->loadReferenceLinks($module)) {
				return false;
			};

			$moduleFile = $moduleObject->path . "module.php";
			$className = "xyo_Module";
			$module = $moduleObject->module;
			if (file_exists($moduleFile)) {
				require_once($moduleFile);
			};

			$moduleObject->className = $className;

			if ($className === "xyo_Module") {
				if (array_key_exists($module, $this->referenceBase)) {
					$base = &$this->getModuleObject($this->referenceBase[$module]);
					if ($base) {
						if ($base->loaded) {
							$moduleObject->baseClass = "*";
							$moduleObject->className = $base->className;
						} else {
							return false;
						};
					};
				};
			} else {
				$moduleObject->baseClass = $className;
			};			

			$moduleObject->loaded = true;
			$moduleObject->object = new $moduleObject->className($moduleObject, $this);
			if ($moduleObject->enabled) {
				$moduleObject->object->moduleInit();
			};

			return $moduleObject->enabled;
		};
		return false;
	}

	public function requireModule($module) {
		if(!$this->loadModule($module)) {
			die("FATAL: Required module ".$module." not found.");
		};
	}

	public function setModuleCheck($module, $check) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleObject->check = $check;
		};
	}	

	public function setModule($moduleParent, $path, $module, $enabled=true, $registered=true, $override=false) {
		if (!$override) {
			if (array_key_exists($module, $this->moduleList)) {
				$this->moduleList[$module]->enabled = $enabled;
				return true;
			};
		};

		if(is_null($moduleParent)) {
			$moduleParent = "";
		};
		if(is_null($path)) {
			$path = "";
		};

		if (strlen($moduleParent) > 0) {
			if (array_key_exists($moduleParent, $this->moduleList)) {
			
			} else {
				$check = &$this->getModuleObject($moduleParent);
				if (!$check) {
					return false;
				};
			};
		};

		$pathModule = null;

		if (strlen($moduleParent) > 0) {
			if (strlen($path) > 0) {
				$pathModule = $this->moduleList[$moduleParent]->path . $path . "/";
			} else {
				$pathModule = $this->moduleList[$moduleParent]->path . $module . "/";
			};
		} else if (strlen($path) > 0) {
			$pathModule = $path . "/";
		} else {
			$pathModule = $this->path . "module/" . $module . "/";
		};		

		$this->moduleList[$module] = new xyo_ModuleObject();
		$this->moduleList[$module]->parent = $moduleParent;
		$this->moduleList[$module]->module = $module;
		$this->moduleList[$module]->className = null;
		$this->moduleList[$module]->enabled = $enabled;
		$this->moduleList[$module]->path = $pathModule;
		$this->moduleList[$module]->init = false;
		$this->moduleList[$module]->loaded = false;
		$this->moduleList[$module]->check = false;		
		$this->moduleList[$module]->application = null;
		$this->moduleList[$module]->baseClass = null;
		$this->moduleList[$module]->pathBase = null;
		$this->moduleList[$module]->registered = $registered;
		$this->moduleList[$module]->object = null;
		$this->moduleList[$module]->instance = "";
		$this->moduleList[$module]->defaultInstance = "";
		return true;
	}

	public function removeModule($module) {
		if (array_key_exists($module, $this->modulesList)) {
			unset($this->modulesList[$module]);
		};
	}	

	public function getModuleRunPath($module) {
		$moduleName = $module;
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleName = $moduleObject->module;
			while ($moduleObject) {
				if ($moduleObject->registered) {
					return $moduleName;
				}
				$moduleObject = &$this->getModuleObject($moduleObject->parent);
				if ($moduleObject) {
					$moduleName = $moduleObject->module . "." . $moduleName;
				};
			};
		};
		return $moduleName;
	}

	public function setReferenceLink($derivate, $base) {
		if (array_key_exists($derivate, $this->referenceLinks)) {

		} else {
			$this->referenceLinks[$derivate] = array();
		};
		$this->referenceLinks[$derivate][$base] = $base;
	}

	public function setReferenceBase($derivate, $base) {
		$this->setReferenceLink($derivate, $base);
		$this->referenceBase[$derivate] = $base;
	}

	public function loadReferenceLinks($derivate) {
		if (array_key_exists($derivate, $this->referenceLinks)) {
			foreach ($this->referenceLinks[$derivate] as $base) {
				if (!$this->loadModule($base)) {
					die("FATAL: Load fail - [" . $base . "] on [" . $derivate . "]");
				};
			};
		};
		return true;
	}

	public function setVersion($module, $version) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleObject->version = $version;
		};
	}

	public function getVersion($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			return $moduleObject->version;
		};
		return null;
	}

	public function loadModuleRunPath($module) {

		if (strlen($module) == 0) {
			return null;
		};

		$m = explode(".", $module);
		if (is_array($m)) {
			$module = array_pop($m);
			if (strlen($module) == 0) {
				return null;
			};
			if (!array_key_exists($module, $this->moduleList)) {
				foreach ($m as $v) {
					if ($this->loadModule($v)) {

					} else {
						return null;
					};
				};
			};
		};
		return $module;
	}

	public function moduleFromRunPath($module) {
		if (strlen($module) == 0) {
			return null;
		};

		$m = explode(".", $module);
		if (is_array($m)) {
			$module = array_pop($m);
			if (strlen($module) == 0) {
				return null;
			};
		};
		return $module;
	}

	public function isModuleLoaded($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			if ($moduleObject->enabled) {
				if ($moduleObject->loaded) {
					return true;
				};
			};
		};
		return false;
	}

	public function isModuleEnabled($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			if ($moduleObject->enabled) {
				return true;
			};
		};
		return false;
	}

	public function setModuleAsApplication($module, $enabled=true) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleObject->application = $enabled;
			return true;
		};
		return false;
	}

	public function isModuleAnApplication($module) {
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			if ($moduleObject->application) {
				return true;
			};
		};
		return false;
	}

	public function setInstance($module,$instance){
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleObject->instance=$instance;
			return true;
		};
		return false;
	}

	public function setDefaultInstance($module,$defaultInstance){
		$moduleObject = &$this->getModuleObject($module);
		if ($moduleObject) {
			$moduleObject->defaultInstance=$defaultInstance;
			return true;
		};
		return false;
	}

	//
	// Group Manager
	//

	protected $groupList;
	protected $groupLoader;
	protected $groupLoadedOk;

	protected function initGroupManager() {

		$this->groupLoader = null;
		$this->groupList = array();
		$this->groupLoadedOk = array();

	}

	public function setGroupLoader($name) {
		$this->groupLoader = &$this->getModule($name);
	}

	public function &getGroup($group) {
		$moduleList = array();

		if (!array_key_exists($group, $this->groupLoadedOk)) {
			$this->groupLoaderOk[$group] = true;
			if ($this->groupLoader) {
				$this->groupLoader->systemSetGroup($group);
			};
		};

		if (!array_key_exists($group, $this->groupList)) {
			return $moduleList;
		};

		asort($this->groupList[$group]);
		$moduleList = array_keys($this->groupList[$group]);
		return $moduleList;
	}

	public function runGroup($group, $parameters=null) {
		$moduleList = &$this->getGroup($group);
		foreach ($moduleList as $module) {
			$this->runModule($module, $parameters);
		};
	}

	public function loadGroup($group) {
		$moduleList = &$this->getGroup($group);
		foreach ($moduleList as $module) {
			$this->loadModule($module);
		};
	}

	public function setModuleGroup($module, $group, $order=0) {
		if (!array_key_exists($group, $this->groupList)) {
			$this->groupList[$group] = array();
		};
		$this->groupList[$group][$module] = $order;
	}

	public function removeModuleFromGroup($module, $group) {
		if (array_key_exists($group, $this->groupList)) {
			unset($this->groupList[$group][$module]);
		};
	}

	public function removeGroup($group) {
		if (array_key_exists($group, $this->groupList)) {
			unset($this->groupList[$group]);
		};
	}

	//
	// Application Manager
	//

	protected $application;
	protected $defaultApplication;
	protected $redirectApplication=null;
	protected $redirectApplicationParameters=null;

	private function initApplicationManager() {
		$this->application=null;
		$this->defaultApplication=null;
		$this->redirectApplication=null;
		$this->redirectApplicationParameters=null;
	}

	public function setApplication($module) {
		$this->application = $module;
	}

	public function isApplication($name) {
		return ($this->application === $name);
	}

	public function getApplication() {
		if($this->hasApplication()){
			return $this->application;		
		};
		return $this->defaultApplication;
	}

	public function hasApplication() {
		return !(is_null($this->application) || strlen($this->application)==0);
	}

	public function hasApplicationOrDefault() {
		if(strlen($this->application)>0){
			return true;
		};
		return strlen($this->defaultApplication)>0;
	}

	public function generateApplicationView($parameters=null) {
		if ($this->application) {
			$applicationModule=&$this->getModule($this->application);
			if($applicationModule) {
				return $applicationModule->applicationView($parameters);
			};
		};
		return null;
	}

	public function setDefaultApplication($name) {
		if(!$this->defaultApplication){
			$this->defaultApplication=$name;
		};
	}

	public function getDefaultApplication() {
		return $this->defaultApplication;
	}

	public function redirectApplication($name,$parameters=null) {
		$this->redirectApplication=$name;
		$this->redirectApplicationParameters=$parameters;
	}

	public function processApplication($name,$parameters=null) {
		if(is_null($this->redirectApplication)) {
			$this->redirectApplication=$name;
			$this->redirectApplicationParameters=$parameters;
		};
		while($this->redirectApplication) {
			$this->application=$this->redirectApplication;
			$parameters_=$this->redirectApplicationParameters;
			$this->redirectApplication=null;
			$this->redirectApplicationParameters=null;

			$applicationModule=&$this->getModule($this->application);
			if($applicationModule) {
				$applicationModule->mergeParameters($parameters_);
				$applicationModule->applicationPrepare();
				$applicationModule->applicationInit();				
				$applicationModule->applicationAction();
			};
		};
	}


	//
	//  Request Manager
	//

	protected $request;
	protected $requestBuilder;
	public $isAjax;
	public $isAjaxJs;
	public $isJson;
	public $requestUriRedirectList;
	public $requestUriRedirectListInverse;
	protected $requestPost;

	private function initRequestManager() {
		$this->request=new xyo_Attributes(array_merge(xyo_Cloud_Request__stripSlashesDeep($_COOKIE),xyo_Cloud_Request__stripSlashesDeep($_GET),xyo_Cloud_Request__stripSlashesDeep($_POST)));
		$this->requestBuilder=null;
		$this->isAjax=false;
		$this->isAjaxJs=false;
		$this->isJson=false;
		$this->requestUriRedirectList=array();
		$this->requestUriRedirectListInverse=array();		
		$this->requestPost =new xyo_Attributes(xyo_Cloud_Request__stripSlashesDeep($_POST));
	}

	public function getRequest($name, $default=null) {
		return $this->request->get($name, $default);
	}

	public function setRequest($name, $value) {
		$this->request->set($name, $value);
	}

	public function getRequestDirect() {
		return $this->request->getAttributes();
	}

	public function setRequestDirect($value) {
		$this->request->setAttributes($value);
	}

	public function clearRequest() {
		$this->request->clear();
	}

	public function mergeRequest($value) {
		$this->request->merge($value);
	}

	public function isRequest($name) {
		return $this->request->is($name);
	}

	public function unsetRequest($name) {
		$this->request->unsetAttribute($name);
	}

	public function initRequest() {
		$this->isAjax=1*$this->request->get("ajax",0);
		$this->isAjaxJs=1*$this->request->get("ajax-js",0);
		$this->isJson=1*$this->request->get("json",0);

		$redirect=$this->request->get("__","");
		if(strlen($redirect)>0) {
			$redirectList=explode("/",$redirect);
			if(count($redirectList)>0) {
				//  /run/[module-name]
				if($redirectList[0]=="run") {
					if(count($redirectList)>1) {
						$this->request->set("run",$redirectList[1]);
					};
				};
			};
		};

	}

	public function initRequestRedirect() {
		$siteRequest=$this->get("site_request","");
		$siteBase=$this->get("site_base","");
		$siteRedirect="/";
		if(strlen($siteRequest)){
			if(strlen($siteBase)){
				$siteRedirect=substr($siteRequest,strlen($siteBase)-1);
			};
		};
		$this->set("site_redirect",$siteRedirect);
		$redirect=$this->request->get("__","");
		if(strlen($redirect)>0) {
			$redirect=$siteRedirect.$redirect;
			if(array_key_exists($redirect,$this->requestUriRedirectList)){
				$this->request->merge($this->requestUriRedirectList[$redirect]);
				return;
			};
		};
	}

	public function isRequestRedirect() {
		return (strlen($this->request->get("__",""))>0);
	}

	public function pushRequest($request) {
		if(!$request) {
			return array();
		};
		if(!count($request)) {
			return array();
		};
		$retV=array();
		$sp=0;
		if(array_key_exists("x_",$request)) {
			$sp=1*$request["x_"];
		};
		++$sp;
		$newXSp="x_".$sp."_";
		foreach($request as $key=>$value) {
			if(strncmp($key,"x_",2)==0) {
				$retV[$key]=$value;
			} else {
				$retV[$newXSp.$key]=$value;
			};
		};
		$retV["x_"]=$sp;
		return $retV;
	}

	public function popRequest($request) {
		if(!$request) {
			return array();
		};
		if(!count($request)) {
			return array();
		};
		$retV=array();
		$sp=0;
		if(array_key_exists("x_",$request)) {
			$sp=1*$request["x_"];
		};
		if($sp==0) {
			return array();
		};
		$xSp="x_".$sp."_";
		$xSpLen=strlen($xSp);
		foreach($request as $key=>$value) {
			if(strncmp($xSp,$key,$xSpLen)==0) {
				$retV[substr($key,$xSpLen)]=$value;
			} else if(strncmp($key,"x_",2)==0) {
				$retV[$key]=$value;
			};
		};
		--$sp;
		if($sp>0) {
			$retV["x_"]=$sp;
		} else {
			unset($retV["x_"]);
		};
		return $retV;
	}

	public function getRequestStack($request) {
		$retV=array();
		foreach($request as $key=>$value) {
			if(strncmp($key,"x_",2)==0) {
				$retV[$key]=$value;
			};
		};
		return $retV;
	}

	public function hasRequestStack($request) {
		if(array_key_exists("x_",$request)) {
			return true;
		};
		return false;
	}


	public function moduleFromRequest($request) {
		if(array_key_exists("run",$request)) {
			return $request["run"];
		};
		return null;
	}

	public function moduleFromRequestDirect($request) {
		if(array_key_exists("run",$request)) {
			return array("run"=>$request["run"]);
		};
		return array();
	}

	public function callRequest($requestThis,$requestCall=null) {
		if(!$requestCall) {
			return $requestThis;
		};
		$retV=$this->pushRequest($requestThis);
		return array_merge($retV,$requestCall);
	}

	public function returnRequest($requestThis,$requestReturn=null) {
		if(!$requestReturn) {
			return $this->popRequest($requestThis);
		};
		$retV=$this->popRequest($requestThis);
		return array_merge($retV,$requestReturn);
	}

	public function runRequest($parameters) {
		$module=$this->loadModuleRunPath($this->get("run"));
		if($module) {
			return $this->runModule($module,$parameters);
		};
		return null;
	}

	public function setRequestBuilder($requestBuilder) {
		$this->requestBuilder=$requestBuilder;
	}

	public function requestUriRoute($requestMain=null,$parameters=null) {

		if ($this->requestBuilder) {
			return $this->requestBuilder->systemRequestUriRoute($requestMain,$parameters);
		};

		if(strlen($requestMain)==0) {
			$requestMain="index.php";
		};

		$redirect=$this->getRequest("__","");
		if((strlen($redirect)>0)||$this->get("use_redirect",false)) {
			if ($parameters) {

					$found=false;
					$siteRedirect=$this->cloud->get("site_redirect","");
					if(strlen($siteRedirect)){
						if (array_key_exists("run", $parameters)) {
							$siteRedirect.="run/".rawurlencode($parameters["run"]);
							if(array_key_exists($siteRedirect,$this->requestUriRedirectListInverse)){
								$siteRedirect=$this->cloud->get("site_base","").substr($this->requestUriRedirectListInverse[$siteRedirect],1);
								$found=true;
							};
						};
					};

					$retV=$siteRedirect;
					if(!$found){
						$retV=$this->cloud->get("site_request",$this->cloud->get("site",""));
						if (array_key_exists("run", $parameters)) {
							$retV.="run/".rawurlencode($parameters["run"]);
						};
					};

					$first = false;
					foreach ($parameters as $key => $value) {
						if ($key === "run") {
							continue;
						};
						if (is_null($value)) {
							$value="";
						};
						if ($first) {
							$retV.="&";
						} else {
							$retV.="?";
							$first = true;
						};
						$retV.=rawurlencode($key) . "=" . rawurlencode($value);
					};
					return $retV;
			};
			return $this->cloud->get("site_request",$this->cloud->get("site",""));
		};

		$retV = $requestMain;
		if ($parameters) {
			$first = false;
			if (array_key_exists("run", $parameters)) {
				$retV.="?run=" . rawurlencode($parameters["run"]);
				$first = true;
			};
			foreach ($parameters as $key => $value) {
				if ($key === "run") {
					continue;
				};
				if ($first) {
					$retV.="&";
				} else {
					$retV.="?";
					$first = true;
				};
				$retV.=rawurlencode($key) . "=" . rawurlencode($value);
			};
		};
		return $retV;
	}

	public function getSiteFromServerRequest() {
		if(array_key_exists("REQUEST_URI",$_SERVER)) {
			$site=$_SERVER["REQUEST_URI"];
			$x=@strrpos($site,"?",-1);
			if($x!==false) {
				$site=substr($site,0,$x);
			};
			$x=@strrpos($site,"/",-1);
			if($x!==false) {
				$redirect=$this->getRequest("__","");
				if(strlen($redirect)>0) {
					return substr($site,0,strlen($site)-strlen($redirect));
				};
				return substr($site,0,$x+1);
			};
		};
		return "";
	}

	public function setSiteFromServerRequest() {
		if ($this->requestBuilder) {
			return $this->requestBuilder->systemSetSiteFromServerRequest();
		};
		$site=$this->get("site","");
		if(strlen($site)==0) {
			$this->set("site",$this->getSiteFromServerRequest());
		};
		$siteBase=$this->get("site_base","");
		if(strlen($siteBase)==0) {
			$this->set("site_base",$this->get("site",""));
		};		
	}

	public function setSiteBase() {
		$pathRequest=$this->get("site_request", "");
		$pathSite=$this->get("site", "");
		$intersect="";
		$pathRequestLn=strlen($pathRequest);
		$pathSiteLn=strlen($pathSite);
		$intersectLn=min($pathRequestLn,$pathSiteLn);
		for($scan=0;$scan<$intersectLn;++$scan){
			if($pathRequest[$scan]==$pathSite[$scan]){
				$intersect.=$pathRequest[$scan];
				continue;
			};
			break;
		};
		$this->set("site_base",$intersect);
	}

	public function setPathSite($pathSite = "", $pathRequest = "") {
		$site = $this->getSiteFromServerRequest();
		if(strlen($pathRequest)>0) {
			$this->set("site_request", $this->rebuildPath($site.$pathRequest."/"));
		} else {
			$this->set("site_request", $site);
		};
		if(strlen($pathSite)>0) {
			$this->set("site",$this->rebuildPath($site.$pathSite."/"));
		} else {
			$this->set("site",$site);
		};
		$this->setSiteBase();
	}

	public function requestUri($parameters=null) {
		return $this->requestUriRoute($this->get("request_main","index.php"),$parameters);
	}

	public function requestModuleDirect($module, $parameters=null) {
		if (!$parameters) {
			$parameters = array();
		};
		if($module) {
			$module_ = $this->getModuleRunPath($module);
			$parameters["run"] = $module_;
		};
		return $parameters;
	}

	public function requestUriModule($module, $parameters=null) {
		return $this->requestUri($this->requestModuleDirect($module, $parameters));
	}

	public function requestUriRouteModule($requestMain,$module, $parameters=null) {
		return $this->requestUriRoute($requestMain,$this->requestModuleDirect($module, $parameters));
	}

	public function getModuleNameFromRequest() {
		$module=$this->getRequest("run",$this->application);
		if($module) {
			$m = explode(".", $module);
			if (is_array($m)) {
				return array_pop($m);
			};
			return $module;
		};
		return null;
	}

	public function getParameterRequest($name, $parameters, $default=null) {
		if ($parameters) {
			if (array_key_exists($name, $parameters)) {
				return $parameters[$name];
			};
		};
		return $this->getRequest($name, $default);
	}

	public function isParameterRequest($name, $parameters) {
		if ($parameters) {
			if (array_key_exists($name, $parameters)) {
				return true;
			};
		};
		return $this->isRequest($name);
	}

	public function requestUriRedirect($uri,$request,$inverseUri=null){
		$this->requestUriRedirectList[$uri]=$request;
		if($inverseUri){
			if(!array_key_exists($inverseUri,$this->requestUriRedirectListInverse)){
				$this->requestUriRedirectListInverse[$inverseUri]=$uri;
			};
		};
	}

	public function getPostRequest($name, $default=null) {		
		return $this->requestPost->get($name, $default);
	}

	//
	// Storage Manager
	//

	public function getStoragePath($module) {
		return "repository/module/".$module;
	}

	public function getStorageFilename($module,$fileName) {
		return "repository/module/".$module."/".$fileName;
	}

	//
	// HTML Manager
	//

	protected $htmlClassList;
	protected $htmlBodyClassList;
	protected $htmlCssList;
	protected $htmlCssSourceList;
	protected $htmlJsList;
	protected $htmlJsSourceList;
	protected $htmlTitle;
	protected $htmlDescription;
	protected $htmlIcon;

	private function initHtmlManager() {
		$this->htmlClassList=array();
		$this->htmlBodyClassList=array();
		$this->htmlCssList=array();
		$this->htmlCssSourceList=array();
		$this->htmlJsList=array();
		$this->htmlJsSourceList=array();
		$this->htmlTitle="XYO Cloud";
		$this->htmlDescription="";
		$this->htmlIcon="favicon.ico";
	}

	public function setHtmlClass($class) {
		$this->htmlClassList[$class]=$class;
	}

	public function removeHtmlClass($class) {
		if(array_key_exists($class,$this->htmlClassList)) {
			unset($this->htmlClassList[$class]);
		};
	}

	public function getHtmlClass() {
		$retV="";
		foreach($this->htmlClassList as $class) {
			if(strlen($retV)) {
				$retV.=" ";
			};
			$retV.=$class;
		};
		return $retV;
	}

	public function eHtmlClass() {
		$value=$this->getHtmlClass();
		if($value) {
			echo " class=\"".$value."\"";
		};
	}

	public function setHtmlBodyClass($class) {
		$this->htmlBodyClassList[$class]=$class;
	}

	public function removeHtmlBodyClass($class) {
		if(array_key_exists($class,$this->htmlBodyClassList)) {
			unset($this->htmlBodyClassList[$class]);
		};
	}

	public function getHtmlBodyClass() {
		$retV="";
		foreach($this->htmlBodyClassList as $class) {
			if(strlen($retV)) {
				$retV.=" ";
			};
			$retV.=$class;
		};
		return $retV;
	}

	public function eHtmlBodyClass() {
		$value=$this->getHtmlBodyClass();
		if($value) {
			echo " class=\"".$value."\"";
		};
	}

	public function eHtmlLanguage() {
		echo " lang=\"".$this->get("language","en")."\"";
	}

	public function setHtmlJs($module,$url,$opt="") {
		if(!array_key_exists($module,$this->htmlJsList)) {
			$this->htmlJsList[$module]=array();
		};
		$this->htmlJsList[$module][$url]=array(0 => $url, 1 => $opt);
	}

	public function removeHtmlJs($module,$url) {
		if(!array_key_exists($module,$this->htmlJsList)) {
			return;
		};
		unset($this->htmlJsList[$module][$url]);
	}

	public function removeHtmlJsAll($module) {
		if(!array_key_exists($module,$this->htmlJsList)) {
			return;
		};
		unset($this->htmlJsList[$module]);
	}

	public function setHtmlJsBefore($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlJsList)) {
			if(array_key_exists($moduleOther,$this->htmlJsList)) {
				$keys = array_keys($this->htmlJsList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 > $pos2){
					$part1 = array_splice($this->htmlJsList, $pos1, 1);
					$part2 = array_splice($this->htmlJsList, 0, $pos2);
					$this->htmlJsList = array_merge($part2,$part1,$this->htmlJsList);
				};
			};
		};
	}

	public function setHtmlJsAfter($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlJsList)) {
			if(array_key_exists($moduleOther,$this->htmlJsList)) {
				$keys = array_keys($this->htmlJsList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 < $pos2){
					$part1 = array_splice($this->htmlJsList, 0, $pos2 + 1);
					$part2 = array_splice($part1, $pos1, 1);
					$this->htmlJsList = array_merge($part1,$part2,$this->htmlJsList);
				};
			};
		};
	}

	public function eHtmlJs() {
		foreach($this->htmlJsList as $key=>$js) {
			foreach($js as $info) {
				$extra="";
				if(strlen($info[1])>0) {
					$extra=" ".$info[1];
				};
				echo "<script src=\"" . $info[0] . "\"".$this->sCSPNonce().$extra."></script>\n";
			};
		};
	}

	public function setHtmlJsSource($module,$code,$opt="none") {
		if(!array_key_exists($module,$this->htmlJsSourceList)) {
			$this->htmlJsSourceList[$module]=array();
		};
		$this->htmlJsSourceList[$module][]=array(0=>$code,1=>$opt);
	}

	public function removeHtmlJsSourceAll($module) {
		if(!array_key_exists($module,$this->htmlJsSourceList)) {
			return;
		};
		unset($this->htmlJsSourceList[$module]);
	}

	public function setHtmlJsSourceBefore($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlJsSourceList)) {
			if(array_key_exists($moduleOther,$this->htmlJsSourceList)) {
				$keys = array_keys($this->htmlJsSourceList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 > $pos2){
					$part1 = array_splice($this->htmlJsSourceList, $pos1, 1);
					$part2 = array_splice($this->htmlJsSourceList, 0, $pos2);
					$this->htmlJsSourceList = array_merge($part2,$part1,$this->htmlJsSourceList);
				};
			};
		};
	}

	public function setHtmlJsSourceAfter($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlJsSourceList)) {
			if(array_key_exists($moduleOther,$this->htmlJsSourceList)) {
				$keys = array_keys($this->htmlJsSourceList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 < $pos2){
					$part1 = array_splice($this->htmlJsSourceList, 0, $pos2 + 1);
					$part2 = array_splice($part1, $pos1, 1);
					$this->htmlJsSourceList = array_merge($part1,$part2,$this->htmlJsSourceList);
				};
			};
		};
	}

	public function eHtmlJsSource() {
		if(count($this->htmlJsSourceList)>0) {			
			$simple=array();
			$load=array();

			foreach($this->htmlJsSourceList as $key=>$js) {
				foreach($js as $code) {
					if($code[1]==="load") {
						$load[]=$code[0];
						continue;
					};
					$simple[]=$code[0];
				};
			};

			if(count($simple)||count($load)) {
				echo "<script".$this->sCSPNonce().">\n";
				foreach($simple as $code) {
					echo $code;
				};
				if(count($load)) {
					echo "var __load__=function(){";
					echo "window.removeEventListener(\"load\", __load__);\n";
					foreach($load as $code) {
						echo $code;
					};
					echo "__load__=null;};\n";
					echo "window.addEventListener(\"load\",__load__);\n";
				};
				echo "</script>\n";
			};
		};
	}

	public function setHtmlCss($module,$url) {
		if(!array_key_exists($module,$this->htmlCssList)) {
			$this->htmlCssList[$module]=array();
		};
		$this->htmlCssList[$module][$url]=$url;
	}

	public function removeHtmlCss($module,$url) {
		if(!array_key_exists($module,$this->htmlCssList)) {
			return;
		};
		unset($this->htmlCssList[$module][$url]);
	}

	public function removeHtmlCssAll($module) {
		if(!array_key_exists($module,$this->htmlCssList)) {
			return;
		};
		unset($this->htmlCssList[$module]);
	}

	public function setHtmlCssBefore($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlCssList)) {
			if(array_key_exists($moduleOther,$this->htmlCssList)) {
				$keys = array_keys($this->htmlCssList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 > $pos2){
					$part1 = array_splice($this->htmlCssList, $pos1, 1);
					$part2 = array_splice($this->htmlCssList, 0, $pos2);
					$this->htmlCssList = array_merge($part2,$part1,$this->htmlCssList);
				};
			};
		};
	}

	public function setHtmlCssAfter($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlCssList)) {
			if(array_key_exists($moduleOther,$this->htmlCssList)) {
				$keys = array_keys($this->htmlCssList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 < $pos2){
					$part1 = array_splice($this->htmlCssList, 0, $pos2 + 1);
					$part2 = array_splice($part1, $pos1, 1);
					$this->htmlCssList = array_merge($part1,$part2,$this->htmlCssList);
				};
			};
		};
	}

	public function eHtmlCss() {
		foreach($this->htmlCssList as $key=>$css) {
			foreach($css as $url) {
				echo "<link rel=\"stylesheet\" href=\"" . $url . "\"".$this->sCSPNonce().">\n";
			};
		};
	}

	public function setHtmlCssSource($module,$code) {
		if(!array_key_exists($module,$this->htmlCssSourceList)) {
			$this->htmlCssSourceList[$module]=array();
		};
		$this->htmlCssSourceList[$module][]=$code;
	}

	public function removeHtmlCssSourceAll($module) {
		if(!array_key_exists($module,$this->htmlCssSourceList)) {
			return;
		};
		unset($this->htmlCssSourceList[$module]);
	}

	public function setHtmlCssSourceBefore($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlCssSourceList)) {
			if(array_key_exists($moduleOther,$this->htmlCssSourceList)) {
				$keys = array_keys($this->htmlCssSourceList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 > $pos2){
					$part1 = array_splice($this->htmlCssSourceList, $pos1, 1);
					$part2 = array_splice($this->htmlCssSourceList, 0, $pos2);
					$this->htmlCssSourceList = array_merge($part2,$part1,$this->htmlCssSourceList);
				};
			};
		};
	}

	public function setHtmlCssSourceAfter($module,$moduleOther) {
		if(array_key_exists($module,$this->htmlCssSourceList)) {
			if(array_key_exists($moduleOther,$this->htmlCssSourceList)) {
				$keys = array_keys($this->htmlCssSourceList);
				$pos1 = array_search($module, $keys);
				$pos2 = array_search($moduleOther, $keys);
				if($pos1 < $pos2){
					$part1 = array_splice($this->htmlCssSourceList, 0, $pos2 + 1);
					$part2 = array_splice($part1, $pos1, 1);
					$this->htmlCssSourceList = array_merge($part1,$part2,$this->htmlCssSourceList);
				};
			};
		};
	}

	public function eHtmlCssSource() {
		if(count($this->htmlCssSourceList)>0) {
			echo "<style".$this->sCSPNonce().">\n";
			foreach($this->htmlCssSourceList as $key=>$css) {
				foreach($css as $code) {
					echo $code;
				};
			};
			echo "</style>\n";
		};
	}

	public function setHtmlTitle($title) {
		$this->htmlTitle=$title;
	}

	public function eHtmlTitle() {
		if(strlen($this->htmlTitle)>0) {
			echo "<title>".$this->htmlTitle."</title>\n";
		};
	}

	public function setHtmlDescription($description) {
		$this->htmlDescription=$description;
	}

	public function eHtmlDescription() {
		if(strlen($this->htmlDescription)>0) {
			echo "<meta name=\"description\" content=\"".$this->htmlDescription."\">\n";
		};
	}

	public function setHtmlIcon($uri) {
		$this->htmlIcon=$uri;
	}

	public function eHtmlIcon() {
		if(strlen($this->htmlIcon)>0) {
			echo "<link rel=\"icon\" href=\"".$this->htmlIcon."\">\n";
		};
	}

	public function setHtmlCssSourceOrAjax($module,$source) {
		if(strlen($source)==0){
			return;
		};
		if($this->isAjaxJs) {			
			return;
		};
		if($this->isAjax) {
			echo "<style".$this->sCSPNonce().">\n";
			echo $source;
			echo "</style>\n";
			return;
		};
		$this->setHtmlCssSource($module,$source);
	}

	public function eCssSourceAjax($source) {
		if(strlen($source)==0){
			return;
		};
		if($this->isAjaxJs) {			
			return;
		};
		if($this->isAjax) {
			echo "<style".$this->sCSPNonce().">\n";
			echo $source;
			echo "</style>\n";
			return;
		};
	}

	public function eHtmlStyle() {
		$this->eHtmlCss();
		$this->eHtmlCssSource();
	}

	public function setHtmlJsSourceOrAjax($module,$source,$opt="none") {
		if(strlen($source)==0){
			return;
		};
		if($this->isAjaxJs) {
			echo $source;
			return;
		};
		if($this->isAjax) {
			echo "<script".$this->sCSPNonce().">\n";
			echo $source;
			echo "</script>\n";
			return;
		};
		$this->setHtmlJsSource($module,$source,$opt);
	}

	public function eJsSourceAjax($source) {
		if(strlen($source)==0){
			return;
		};
		if($this->isAjaxJs) {
			echo $source;
			return;
		};
		if($this->isAjax) {
			echo "<script".$this->sCSPNonce().">\n";
			echo $source;
			echo "</script>\n";
			return;
		};
	}	

	public function eHtmlScript() {
		$this->eHtmlJs();
		$this->eHtmlJsSource();
	}

	public function setHtmlBefore($module,$moduleOther) {
		$this->setHtmlJsBefore($module,$moduleOther);
		$this->setHtmlJsSourceBefore($module,$moduleOther);
		$this->setHtmlCssBefore($module,$moduleOther);
		$this->setHtmlCssSourceBefore($module,$moduleOther);
	}

	public function setHtmlAfter($module,$moduleOther) {
		$this->setHtmlJsAfter($module,$moduleOther);
		$this->setHtmlJsSourceAfter($module,$moduleOther);
		$this->setHtmlCssAfter($module,$moduleOther);
		$this->setHtmlCssSourceAfter($module,$moduleOther);
	}

	//
	// Template Manager
	//

	protected $template;
	protected $templatePath;

	private function initTemplateManager() {
		$this->template=null;
		$this->templatePath=null;
	}

	public function setTemplate($module) {
		if(!$this->hasTemplate()){
			$this->template = $module;
			$this->templatePath = $this->getModulePath($module);
		};
	}

	public function forceTemplate($module) {
		$this->template = $module;
		$this->templatePath = $this->getModulePath($module);
	}

	public function getTemplate() {
		return $this->template;
	}

	public function getTemplatePath() {
		return $this->templatePath;
	}

	public function hasTemplate() {
		return !(is_null($this->template) || (strlen($this->template)==0));
	}

	//
	// DataSource Manager
	//

	public $dataSource;

	private function initDataSourceManager() {
		$this->dataSource=new xyo_DataSource($this);
		//
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-csv", "xyo-datasource-csv");
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-mysql", "xyo-datasource-mysql");
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-mysqli", "xyo-datasource-mysqli");
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-postgresql", "xyo-datasource-postgresql");
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-sqlite", "xyo-datasource-sqlite");
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-xyo", "xyo-datasource-xyo");
		//
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-quantum", "xyo-datasource-quantum");
		$this->setModule(null, $this->path."xyo/xyo-datasource/xyo-datasource-memory", "xyo-datasource-memory");
	}

	//
	// CSRF Mitigation Manager
	//

	protected $csrfMitigationProvider;

	protected function initCSRFMitigationManager() {
		$this->csrfMitigationProvider = &$this;
	}

	public function setCSRFMitigationProvider($name) {
		$this->csrfMitigationProvider = &$this->getModule($name);
	}

	public function getCSRFMitigationProvider() {
		return $this->csrfMitigationProvider;
	}

	//
	// CSRF Mitigation Dummy provider
	//

	public function systemCsrfReset() {
		return true;
	}

	public function systemCsrfCheck() {
		return true;
	}

	public function systemGetFormCsrfToken() {
		return "";
	}
		
	public function systemGetCsrfToken() {
		return "";
	}

	public function systemGetCsrfTokenJsSource() {		
		return "";
	}

	public function systemSetCsrfReferenceCount($count) {		
	}

	//
	// Content Security Policy Manager
	//

	protected $cspHeader;
	protected $cspNonce;

	protected function initCSPManager() {
		$this->cspNonce="";
		$this->cspHeader="";
	}

	public function initCSP() {
		$this->cspNonce=hash("sha256", $this->getClientIP().".".rand().".".time().session_id(), false);
		if($this->isAjax||$this->isAjaxJs){
			$this->cspNonce=$this->getRequest("csp_nonce",$this->cspNonce);
		};
		$this->cspHeader="default-src 'unsafe-inline' 'nonce-".$this->cspNonce."'; img-src 'self' data:; base-uri 'self'; object-src 'none'; font-src 'self'; connect-src 'self'; style-src-elem 'self' 'nonce-".$this->cspNonce."'"; //"; require-trusted-types-for 'script'";
	}

	public function setCSPHeader($value) {
		$this->cspHeader=$value;
	}

	public function getCSPHeader() {
		return $this->cspHeader;
	}

	public function emitCSPHeader() {
		if(strlen($this->cspHeader)>0){
			header("Content-Security-Policy: ".$this->cspHeader);
		};		
	}

	public function setCSPNonce($value) {
		$this->cspNonce=$value;
	}

	public function getCSPNonce() {
		return $this->cspNonce;
	}

	public function sCSPNonce() {
		if(strlen($this->cspNonce)>0){
			return " nonce=\"".$this->cspNonce."\"";
		};
		return "";
	}

	//
	// Unique Identifier Manager
	//

	protected $uidIndex;

	protected function initUIDManager() {
		$this->uidIndex=0;
	}

	public function getUID() {
		++$this->uidIndex;
		return "uid".$this->uidIndex.time();
	}

	//
	// Main
	//

	protected $isInitOk;
	protected $site;
	protected $path;
	protected $basePath;

	public function __construct() {
		$this->path=realpath(dirname(realpath(__FILE__)) . "/..")."/";

		parent::__construct($this);
		
		$this->set("site","");
		$this->set("use_redirect",false);
		$this->set("log_module",true);
		$this->set("log_request",false);
		$this->set("log_response",false);
		$this->set("request_main","index.php");

		$this->isInitOk=true;

		$this->initModuleManager();
		$this->initGroupManager();
		$this->initApplicationManager();
		$this->initRequestManager();
		$this->initHtmlManager();
		$this->initTemplateManager();
		$this->initDataSourceManager();
		$this->initCSRFMitigationManager();
		$this->initCSPManager();
		$this->initUIDManager();
	}

	public function getClientIP() {
		if(array_key_exists("HTTP_CLIENT_IP",$_SERVER)) {
			return $_SERVER["HTTP_CLIENT_IP"];
		};
		if(array_key_exists("HTTP_X_FORWARDED_FOR",$_SERVER)) {
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		};
		if(array_key_exists("HTTP_X_FORWARDED",$_SERVER)) {
			return $_SERVER["HTTP_X_FORWARDED"];
		};
		if(array_key_exists("HTTP_FORWARDED_FOR",$_SERVER)) {
			return $_SERVER["HTTP_FORWARDED_FOR"];
		};
		if(array_key_exists("HTTP_FORWARDED",$_SERVER)) {
			return $_SERVER["HTTP_FORWARDED"];
		};
		if(array_key_exists("REMOTE_ADDR",$_SERVER)) {
			return $_SERVER["REMOTE_ADDR"];
		};
		return null;
	}

	public function isHTTPS() {
		if(isset($_SERVER["HTTPS"])&&(strtolower($_SERVER["HTTPS"])=="on"||$_SERVER["HTTPS"]==1)){
			return true;
		};
		if(isset($_SERVER["HTTP_X_FORWARDED_PROTO"])&& $_SERVER["HTTP_X_FORWARDED_PROTO"]=="https"){
			return true;
		};
		if(isset($_SERVER["HTTP_FRONT_END_HTTPS"])&&$_SERVER["HTTP_FRONT_END_HTTPS"] === "on"){
			return true;
		};
		return false;
	}

	public function logMessage($type, $message_,$module_=null) {
		$fs = fopen($this->path."log/" . date("Y-m-d")."-". $type.".log", "ab");
		if ($fs) {
			if($module_) {
				fwrite($fs, date("Y-m-d H:i:s") . " [".$this->getModuleRunPath($module_)."] [".$this->getClientIP()."]: ");
			} else {
				fwrite($fs, date("Y-m-d H:i:s") . ": ");
			};
			if (is_array($message_)) {
				fwrite($fs, "Array (\r\n");
				foreach ($message_ as $key => $value) {
					if (is_bool($key)) {
						if ($key) {
							fwrite($fs, "true");
						} else {
							fwrite($fs, "false");
						};
					} else if (is_string($key)) {
						fwrite($fs, "\"" . $key . "\"");
					} else {
						fwrite($fs, $key);
					};
					fwrite($fs, " = ");
					if (is_bool($value)) {
						if ($value) {
							fwrite($fs, "true");
						} else {
							fwrite($fs, "false");
						};
					} else if (is_string($value)) {
						fwrite($fs, "\"" . $value . "\"");
					} else {
						fwrite($fs, $value);
					};
					fwrite($fs, "\r\n");
				}
				fwrite($fs, ")");
			} else {
				fwrite($fs, $message_);
			};
			fwrite($fs, "\r\n");
			fclose($fs);
		};
	}

	public static function logResponseShutdown($x) {
		$retV = ob_get_contents();
		ob_end_clean();
		$fs = fopen($x[0] . date("Y-m-d")."-response.log", "ab");
		if ($fs) {
			fwrite($fs, date("Y-m-d H:i:s") . " [".$x[1]."]\n");
			fwrite($fs, $retV);
			fwrite($fs, "\n\n");
			fclose($fs);
		};
		echo $retV;
	}

	public function setInitOk($value) {
		if ($this->isInitOk) {
			$this->isInitOk = $value;
		};
	}

	public function getCloudPath() {
		return $this->path;
	}

	public function main() {

		// start up session - cookie only
		ini_set("session.use_cookies", 1);
		ini_set("session.use_trans_sid", 0);
		session_start();
		
		if(version_compare(PHP_VERSION, "5.4.0")>=0){
			session_register_shutdown();
		}else{
			register_shutdown_function("session_write_close");
		};
						
		//
		$this->set("log_module",false);
		$this->set("log_request",false);
		$this->set("log_response",false);
		$this->set("log_language",false);
		$this->set("use_redirect",false);
		//
		$this->set("language", "en-gb");
		$this->set("locale", "en-gb");
		$this->set("locale_date_format","Y-m-d");
		$this->set("locale_datetime_format","Y-m-d H:i:s");
		$this->set("locale_time_format","H:i:s");
		//
		$this->initRequest();
		$this->initCSP();
		$this->dataSource->loadConfig();
		$this->includeConfigWithPattern("xyo-cloud");
		//
		$this->setSiteFromServerRequest();
		//
		$this->initRequestRedirect();
		//

		if ($this->get("log_request",false)) {
			ob_start();

			print_r($this->request->getAttributes());

			$retV = ob_get_contents();
			ob_end_clean();
			$fs = fopen($this->path . "log/" . date("Y-m-d")."-request.log", "ab");
			if ($fs) {
				fwrite($fs, date("Y-m-d H:i:s") . " [".$this->getClientIP()."]\n");
				fwrite($fs, $retV);
				fwrite($fs, "\n\n");
				fclose($fs);
			};
		};

		if ($this->get("log_response",false)) {
			ob_start();
			$x=array(0=>$this->path . "log/",1=>$this->getClientIP());
			register_shutdown_function(array("xyo_Cloud","logResponseShutdown"), $x);
		};

		$this->runGroup("system-init");
		if ($this->isInitOk) {

			$this->emitCSPHeader();

			$run_ = true;
			$module = $this->loadModuleRunPath($this->request->get("run",$this->getApplication()));
			if ($module) {
				$this->initModule($module);
				if ($this->isModuleAnApplication($module)) {
					if($this->isAjax || $this->isJson || $this->isAjaxJs) {
						$run_ = false;
						$this->runModule($module);
					};
				} else {
					$run_ = false;
					$this->runModule($module);
				};
			};
			if ($run_) {
				$this->setApplication($module);
				$this->loadGroup("system-load");

				if($this->hasApplicationOrDefault()) {
					$this->processApplication($this->getApplication());
				};

				if($this->hasTemplate()){
					$this->runModule($this->getTemplate());
					return;
				};

				$this->runGroup("system-run");
			};
		};
	}

}

