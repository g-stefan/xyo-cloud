<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$request=$this->getRequestDirect();
if($this->hasRequestStack($request)){
	$request=$this->returnRequest($request);
	echo "<form name=\"".$this->instanceV."fn_return\" method=\"POST\" action=\"".$this->requestUri($this->moduleFromRequestDirect($request))."\">";
	$this->eFormRequestCsrf();
	$this->eFormBuildRequest($request);
	echo "</form>";
	$this->setHtmlRequestCsrfJsSourceOrAjax();
	$this->ejsBegin();
	echo "window.".$this->instanceV."doReturn=function(){";		
		echo "document.forms.".$this->instanceV."fn_return.elements.request_csrf.value=window.requestCSRF;";
		echo "document.forms.".$this->instanceV."fn_return.submit();";
		echo "return false;";
	echo "};";	
	$this->ejsEnd();	
};
