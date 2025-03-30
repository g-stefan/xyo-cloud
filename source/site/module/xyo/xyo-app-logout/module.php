<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$className="xyo_app_Logout";

class xyo_app_Logout extends xyo_Module{

	function __construct(&$object,&$cloud){
		parent::__construct($object,$cloud);
		if($this->isApplication($this->name)){		
			$user=&$this->cloud->getModule("xyo-mod-ds-user");
			if($user){
				$user->makeResetCookie();
				$user->doLogout();		   
			};
			if($this->isApplication($this->name)){
				$this->moduleDisable();
				$this->clearRequest();
				$this->redirectApplication("xyo-app-login");
				return;
                	};
		};
        }

}
