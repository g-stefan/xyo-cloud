/*
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

*/

var XYO = XYO || {};
XYO.Table = {};
XYO.Table.instance={};
XYO.Table.parentInstance={};
XYO.Table.nonce=null;

XYO.Table.setCheckboxState = function (i_, this_) {
	var el;	
	for(k=1; k<=this.instance[i_].id.length; ++k) {
		el=document.getElementById(this.instance[i_].instanceV+"cbox_"+k);
		if(el) {
			el.checked=this_.checked;
		};
	};
	return false;
}

XYO.Table.resetSearch = function (i_,this_,field) {
	if(this_) {
		this_.form.elements[field].value="";
		XYO.Table.doUpdate(i_);
	};
	return false;
}

XYO.Table.selectIdOne = function(i_) {
	var id;
	id=0;
	for(k=1; k<=this.instance[i_].id.length; ++k) {
		el=document.getElementById(this.instance[i_].instanceV+"cbox_"+k);
		if(el) {
			if(el.checked) {
				id=this.instance[i_].id[k-1];
			};
		};
	};
	return id;
}

XYO.Table.selectId = function(i_) {
	var el;
	var id;

       	id="";
        for(k=1;k<=this.instance[i_].id.length; ++k) {
       	    el=document.getElementById(this.instance[i_].instanceV+"cbox_"+k);
            if(el) {
       	        if(el.checked) {
               	    id+=this.instance[i_].id[k-1];
                    id+=",";
       	        };
            };
       	};

	return id;
}

XYO.Table.doCommand = function(i_, action) {
	var id;

       	id=XYO.Table.selectId(i_);

	if(this.instance[i_].embedded) {
		$request="&"+this.instance[i_].instanceV+"action="+action;
		$request+="&"+this.instance[i_].instanceV+"primary_key_value="+id;
		XYO.Table.doUpdate(i_,$request);
	} else {
		var appForm=this.instance[i_].form;
	        appForm.elements[this.instance[i_].instanceV+"action"].value=action;
		appForm.elements[this.instance[i_].instanceV+"primary_key_value"].value=id;
		appForm.elements["csrf_token"]=window.csrfToken;
		appForm.submit();
	};

	return false;
}
    
XYO.Table.doOrderSave = function(i_, key) {
	XYO.Table.doUpdate(i_,
		"&"+this.instance[i_].instanceV+"action=table-order-save"+
		"&"+this.instance[i_].instanceV+"order="+key+
		"&"+this.instance[i_].instanceV+"primary_key_value="+this.instance[i_].id.join(",")
	);
}

XYO.Table.doOrderUp = function(i_,field,key) {
	XYO.Table.doUpdate(i_,
		"&"+this.instance[i_].instanceV+"action=table-order-up"+
		"&"+this.instance[i_].instanceV+"order="+key+
		"&"+this.instance[i_].instanceV+"primary_key_value="+field
	);
}

XYO.Table.doOrderDown = function(i_,field,key) {
	XYO.Table.doUpdate(i_,
		"&"+this.instance[i_].instanceV+"action=table-order-down"+
		"&"+this.instance[i_].instanceV+"order="+key+
		"&"+this.instance[i_].instanceV+"primary_key_value="+field
	);
}

XYO.Table.doToggle = function(i_,field,key,forceRequest) {
	if(forceRequest && (!(this.instance[i_].embedded))){
		var appForm=this.instance[i_].form;
	        appForm.elements[this.instance[i_].instanceV+"action"].value="table-toggle";
		appForm.elements[this.instance[i_].instanceV+"toggle"].value=key;
		appForm.elements[this.instance[i_].instanceV+"primary_key_value"].value=field;
		appForm.elements["csrf_token"]=window.csrfToken;
		appForm.submit();		
		return;
	};
	XYO.Table.doUpdate(i_,
		"&"+this.instance[i_].instanceV+"action=table-toggle"+
		"&"+this.instance[i_].instanceV+"toggle="+key+
		"&"+this.instance[i_].instanceV+"primary_key_value="+field
	);
}

XYO.Table.doRadio = function(i_,field,key) {
	XYO.Table.doUpdate(i_,
		"&"+this.instance[i_].instanceV+"action=table-radio"+
		"&"+this.instance[i_].instanceV+"radio="+key+
		"&"+this.instance[i_].instanceV+"primary_key_value="+field
	);
}
 
XYO.Table.doValueSave = function(i_,key){
	XYO.Table.doUpdate(i_,
		"&"+this.instance[i_].instanceV+"action=table-value-save"+
		"&"+this.instance[i_].instanceV+"value="+key+
		"&"+this.instance[i_].instanceV+"primary_key_value="+this.instance[i_].id.join(",")
	);
}

XYO.Table.doSort = function(i_,field,mode){
	var appForm=this.instance[i_].form;
	if(this.parentInstance.hasOwnProperty(i_)){
		appForm=this.parentInstance[i_].form;
	};
        appForm.elements[this.instance[i_].instanceV+"sort"].value=field+":"+mode;
	XYO.Table.doUpdate(i_);
}

XYO.Table.doUpdate = function(i_,request){
	if(!request){
		request="";
	};
	var instanceV=this.instance[i_].instanceV;
	var fSerialized="";
	if(this.instance[i_].embedded){
		var form_=this.instance[i_].form;
		if(this.parentInstance.hasOwnProperty(i_)){
			form_=this.parentInstance[i_].form;
		};
		fields_={};
		$.each($(form_).serializeArray(), function(_, field) {
			if(field.name.indexOf(i_)==0){
				fields_[field.name] = field.value;
			};
		});
		fSerialized=$.param(fields_);
	}else{
		fSerialized=$(this.instance[i_].form).serialize();
	};	
	document.getElementById(instanceV+"table-loader").style.display="block";
	$.post(
		this.instance[i_].uri,
		fSerialized+request+"&ajax=1&csrf_token="+window.csrfToken+"&csp_nonce="+XYO.Table.nonce
	).done(function(response){		
		XUI.HTML.update(instanceV+"table",response,XYO.Table.nonce);
		document.getElementById(instanceV+"table-loader").style.display="none";
	});
}

XYO.Table.checkboxOnlyOneById = function (i_, id) {
	var el;	
	for(k=1; k<=this.instance[i_].id.length; ++k) {
		el=document.getElementById(this.instance[i_].instanceV+"cbox_"+k);
		if(el) {  
			if(this.instance[i_].id[k-1]==id) {
				el.checked=true;
			}else{
				el.checked=false;
			};
		};
	};
	return false;
}

// Application Search

XYO.Application = XYO.Application || {};

XYO.Application.doSearch = function () {	
	document.getElementById("search").value=document.getElementById("application_search").value;
	XYO.Table.doUpdate("","&submit_search=1");
};

XYO.Application.resetSearch = function () {
	document.getElementById("application_search").value="";
	document.getElementById("search").value="";
	XYO.Table.doUpdate("");
};
