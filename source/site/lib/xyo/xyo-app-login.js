// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT


function hex2x(hex) {
	var retV = [];
	for (var i = 0; i < hex.length; i += 2){
        	retV.push(parseInt(hex.substr(i, 2), 16));
	};
	return retV;
}

function x2pad(x){
	if(x.length<2){
		return "0"+x;
	};
	return x;
}

function x2hex(x) {
	var retV = [];
	for (var i = 0; i < x.length; ++i) {
		retV.push(x2pad(Number(x[i]).toString(16)));
	};
	return retV.join("");
}

function x2xor(x,y,z){
	var retV = [];	
	for (var i = 0; i < x.length; ++i) {
		retV.push(x[i]^y[i]^z[i]);
	};
	return retV;
}

function x2combo(x,y,z){
	return x2hex(x2xor(hex2x(x),hex2x(y),hex2x(z)));
}

function xyoFormLoginAction(fn,salt) {
	var username=(""+fn.elements.user_username.value).toLowerCase();
	var password=fn.elements.user_password.value;
	var rnd=fn.elements.user_rnd.value;
	if((""+password).length>0){
		if(password.match("^hash:")!=="hash:") {
			fn.elements.user_password.value="hash:"+x2combo(sha512((""+username).toLowerCase()+"."+rnd+"."+salt),sha512(password),rnd);
		}
	}
	return true;
}

function xyoLoginFormInit () {
	var elForm=document.getElementById("login");
	elForm.onsubmit=function(){
		return xyoFormLoginAction(elForm,elForm.dataset.salt);
	};
};

function xyoLoginFormOnLoad () {
	window.removeEventListener("load", xyoLoginFormOnLoad);
	xyoLoginFormInit();
};
window.addEventListener("load", xyoLoginFormOnLoad);
