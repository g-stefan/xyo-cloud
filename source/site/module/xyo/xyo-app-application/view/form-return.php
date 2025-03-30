<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$request=$this->getRequestDirect();
if($this->hasRequestStack($request)){
	$request=$this->returnRequest($request);
	echo "<form name=\"".$this->instanceV."fn_return\" method=\"POST\" action=\"".$this->requestUri($this->moduleFromRequestDirect($request))."\">";
	$this->eFormCsrfToken();
	$this->eFormBuildRequest($request);
	echo "</form>";
	$this->setHtmlJsSourceOrAjaxCsrfToken();
	$this->ejsBegin();
	echo "window.".$this->instanceV."doReturn=function(){";		
		echo "document.forms.".$this->instanceV."fn_return.elements.csrf_token.value=window.csrfToken;";
		echo "document.forms.".$this->instanceV."fn_return.submit();";
		echo "return false;";
	echo "};";	
	$this->ejsEnd();	
};
