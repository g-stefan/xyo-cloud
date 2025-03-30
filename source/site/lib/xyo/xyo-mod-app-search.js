/*
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

*/

var XYO = XYO || {};
XYO.Application = XYO.Application || {};
XYO.Application.doSearch = XYO.Application.doSearch || function (){};
XYO.Application.resetSearch = XYO.Application.resetSearch || function () {
	document.getElementById("application_search").value="";
};

/**
 * Initialization
 */
XYO.Application.searchInit = function () {
	var el=document.getElementById("application_search_form");
	if(el) {
		el.onsubmit=function (){
			XYO.Application.doSearch();
			return false;
		};
	};
};

/**
 * On load
 */
XYO.Application.onLoadSearch = function () {
	window.removeEventListener("load", XYO.Application.onLoadSearch);
	XYO.Application.searchInit();
};
window.addEventListener("load", XYO.Application.onLoadSearch);

