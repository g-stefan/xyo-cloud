/*
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//
*/

if(typeof(XYO)=="undefined"){XYO={};};

XYO.Template={};

(function(){

	var this_=this;

	this.init=function(){
		$(".xui.-overlay-scrollbars").overlayScrollbars({scrollbars:{clickScrolling:true}});
		$("#navigation-drawer-content").overlayScrollbars({scrollbars:{clickScrolling:true},clipAlways:false});
		XUI.Dashboard.notifyStateChange=function(){
			var state=this.getState();
			var scrollBars=$("#navigation-drawer-content").overlayScrollbars();
			if(scrollBars){
				if(((state.mode=="normal")||(state.mode=="mini"))&&(state.state=="closed")){
					scrollBars.sleep();
				}else{
					$("ul>li.xui._submenu>ul").each(function(){
						this.style.height = "auto";
					});
					scrollBars.update(true);
				};
			};
		};
		XUI.Dashboard.notifyStateChange();
		$("ul>li.xui._submenu").mouseenter(function() {			
			var el=this.getElementsByTagName("ul");
			if(el.length){				
				el[0].style.height = "auto";
				var state=XUI.Dashboard.getState();
				if(((state.mode=="normal")||(state.mode=="mini"))&&(state.state=="closed")){
					var checkHeight=function(){
						var elRect=el[0].getBoundingClientRect();
						var viewRect=document.body.getBoundingClientRect();
						var elViewHeight=elRect.top+elRect.height;

						if(elViewHeight>viewRect.height){
							elNewHeight=viewRect.height-elRect.top-6; // 6px margin bottom
							el[0].style.height = elNewHeight+"px";
							el[0].style.overflowY = "auto";
						};
					};
				
					setTimeout(checkHeight,500);
					setTimeout(checkHeight,800);
				};
			};
		});
	};

	this.load=function(event){
		window.removeEventListener("load", this_.load);
		this_.init();
	};

	window.addEventListener("load", this.load);

}).apply(XYO.Template);
