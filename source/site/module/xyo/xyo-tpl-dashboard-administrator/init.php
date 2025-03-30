<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

//
// 404
//
if($this->isRequestRedirect()){
	if(!$this->hasApplication()){
		$this->setViewTemplate("404");
		return;
	};
};

//
// this code will push request to force login
//
if($this->user->isAuthorized()){
	if($this->isApplication("xyo-app-logout")){
		$this->setViewTemplate("login");
	};
} else {
	$request=$this->getRequestDirect();
	$module=$this->moduleFromRequest($request);
	if(!($module=="xyo-app-login"||$module=="xyo-app-logout")){
		$this->setRequestDirect($this->callRequest($this->requestModuleDirect($module),$request));
	};
	$this->setApplication("xyo-app-login");
	$this->setViewTemplate("login");
};
