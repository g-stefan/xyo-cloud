<?php                                                                   
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT


defined("XYO_CLOUD") or die("Access is denied");

?>
<thead>
	<tr>
<?php

$script="";
foreach ($this->tableHead as $key => $value) {
	$hasSort=false;

	if ($key === "#") {
		echo "<th class=\"xui-component-table_select --important\">";
	}else{
		$cssClass="";
					
		$hasSort=false;
		if(array_key_exists($key, $this->tableSort)){
			if(strlen($sort_img[$sortState[$key]])){
				$cssClass.=" xui-component-table_sort";
				$hasSort=true;
			};
		};
										
		if (array_key_exists($key, $this->tableType)) {
			if (($this->tableType[$key][0]=="order")||($this->tableType[$key][0]=="value")) {							
				if($hasSort){
					$cssClass.=" --action";
				} else {
					$cssClass.=" xui-component-table_action";
				};
			};
		};					
					
		$isImportant=false;
		if(count($this->tableImportant)==0){
			$isImportant=true;
		}else{
			if(array_key_exists($key,$this->tableImportant)){
				$isImportant=$this->tableImportant[$key];
			};
		};
		if($isImportant){
			$cssClass.=" --important";
		};
			
		echo "<th class=\"".$cssClass." --field-".$key."\">";
	};
	
	if ($key === "#") {
		echo "<div class=\"xui-form-checkbox --box\">";
			echo "<input type=\"checkbox\" id=\"".$this->instanceV."id_0\" name=\"".$this->instanceV."id_0\" value=\"0\">";
			echo "<label for=\"".$this->instanceV."id_0\"></label>";
		echo "</div>";
		echo "</th>";
		$script.="document.getElementById(\"".$this->instanceV."id_0\").onchange=function(){XYO.Table.setCheckboxState('".$this->instance."',this);};";
		$script.="document.getElementById(\"".$this->instanceV."id_0\").onclick=function(){XYO.Table.setCheckboxState('".$this->instance."',this);};";
		continue;
	};

	if (array_key_exists($key, $this->tableSort)){
		$uid=$this->getUID();
		echo "<span id=\"".$uid."\" class=\"xyo-app-table --z-1\">";
		$this->eLanguage($value);
		echo "</span>";
		$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doSort(\"".$this->instance."\",\"".$key."\",\"".$sortNextState[$sortState[$key]]."\");return false;};";
	}else{
		$this->eLanguage($value);
	};

	if (array_key_exists($key, $this->tableType)) {
		if (($this->tableType[$key][0]=="order")||($this->tableType[$key][0]=="value")) {
			$uid=$this->getUID();
			echo "<div id=\"".$uid."\" class=\"xui-button --transparent xui-effect-ripple --primary --icon --small  --size-xy28\">";
				echo "<i class=\"lucide-save\"></i>";
			echo "</div>";
			$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doOrderSave(\"".$this->instance."\",\"" . $key . "\");return false;};";
		};
	};
				 
	if ($hasSort){					
		if(is_array($sort_img[$sortState[$key]])){
			$uid=$this->getUID();
			echo "<div id=\"".$uid."\" class=\"xui-button --transparent xui-effect-ripple -".$sort_img[$sortState[$key]][1]." --icon --small  --size-xy28 --circle\">";
				echo $sort_img[$sortState[$key]][0];	
			echo "</div>";
			$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doSort(\"".$this->instance."\",\"".$key."\",\"".$sortNextState[$sortState[$key]]."\");return false;};";
		}else{
			$uid=$this->getUID();
			echo "<div id=\"".$uid."\" class=\"xui-button --transparent xui-effect-ripple --secondary --icon --small  --size-xy28 --circle\">";
				echo $sort_img[$sortState[$key]];	
			echo "</div>";
			$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doSort(\"".$this->instance."\",\"".$key."\",\"".$sortNextState[$sortState[$key]]."\");return false;};";
		};
	};
        
	echo "</th>";
};

?>
	</tr>
</thead>
<tbody>

<?php

if(!$this->ds){
	echo "<tr>";
	echo "<td class=\"text-center --important bg-xui-danger-500 xyo-app-table --z-3\" colspan=\"".count($this->tableHead)."\">";
		$this->eLanguage("error.datasource_not_found");
		echo ": ".$this->applicationDataSource;
	echo "</td>";
	echo "</tr>";
};

if(($this->ds)&&(count($this->viewData)==0)){
	echo "<tr>";
	echo "<td class=\"text-center text-xui-rock-3-500 --important\" colspan=\"".count($this->tableHead)."\">";
		$this->eLanguage("info.no_records");
	echo "</td>";
	echo "</tr>";
};

$recordId=0;
foreach ($this->viewData as $key => $value) {
       	echo "<tr id=\"".$this->instanceV."row_" . $value[$this->primaryKey] . "\" class=\"-visible\">";
	foreach ($this->tableHead as $key_ => $value_) {

		if ($key_ === "#") {
			echo "<td class=\"xui-component-table_select --important\">";
		}else{
			$isImportant=false;
			if(count($this->tableImportant)==0){
				$isImportant=true;
			}else{
				if(array_key_exists($key_,$this->tableImportant)){
					$isImportant=$this->tableImportant[$key_];
				};
			};
				
			$classImportant="";
			if($isImportant){
				$classImportant="--important";
			};

			if (array_key_exists($key_, $this->tableType)) {
				if(($this->tableType[$key_][0]=="toggle")||
					($this->tableType[$key_][0]=="radio")||
					($this->tableType[$key_][0]=="toggle-read-only")||
					($this->tableType[$key_][0]=="radio-read-only")){
						$classImportant.=" xui-component-table_action";
				};
			};

			echo "<td class=\"".$classImportant." --field-".$key_."\">";
		};

		if ($key_ === "#") {
			++$recordId;
			if($value["@write"]){
		        	echo "<div class=\"xui-form-checkbox --box --small \"><input type=\"checkbox\" id=\"".$this->instanceV."cbox_" . $recordId . "\"  name=\"".$this->instanceV."id_" . $value[$this->primaryKey] . "\" value=\"" . $value[$this->primaryKey] . "\" ></input><label for=\"".$this->instanceV."cbox_" . $recordId . "\"></label></div>";
			}else{
				echo "&#160;";
			};				
		} else
		if (array_key_exists($key_, $this->tableType)) {
                
			if($this->tableType[$key_][0]=="toggle"){

				$img = 0;
		                if ($value[$key_]) {
        		        	$img = 1;
				};

				$forceCommand="0";

				$toggle_img_=$toggle_img;
				$toggle_off_img_=$toggle_off_img;
				if(array_key_exists(1,$this->tableType[$key_])){
					if(array_key_exists("on",$this->tableType[$key_][1])){
						$toggle_img_=array(
							0=>$this->tableType[$key_][1]["on"][0],
							1=>$this->tableType[$key_][1]["on"][1]
						);									
					};
					if(array_key_exists("off",$this->tableType[$key_][1])){
						$toggle_off_img_=array(
							0=>$this->tableType[$key_][1]["off"][0],
							1=>$this->tableType[$key_][1]["off"][1]
						);
					};
					if(array_key_exists("force-command",$this->tableType[$key_][1])){
						if($this->tableType[$key_][1]["force-command"]){
							$forceCommand="1";
						};
					};
				};

				if($value["@write"]){

		                       	if(is_array($toggle_img_[$img])){
						$uid=$this->getUID();
						$cssMod="";
						if(strlen($toggle_img_[$img][1])){
							$cssMod="--".$toggle_img_[$img][1];
						};
						echo "<div id=\"".$uid."\" class=\"xui-button ".$cssMod." --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
						$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doToggle(\"".$this->instance."\",\"" . $value[$this->primaryKey] . "\",\"" . $key_ . "\",".$forceCommand.");return false;};";
					} else {
						$uid=$this->getUID();
						echo "<div id=\"".$uid."\" class=\"xui-button --primary --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left\">";
						echo $toggle_img_[$img];
						echo "</div>";
						$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doToggle(v".$this->instance."\",\"" . $value[$this->primaryKey] . "\",\"" . $key_ . "\",".$forceCommand.");return false;};";
					};

				}else{
                        
					if(is_array($toggle_img_[$img])){
						echo "<div class=\"xui-button --disabled --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui-button --disabled --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};
				};

			}else
			if(($this->tableType[$key_][0]=="toggle-read-only")||($this->tableType[$key_][0]=="radio-read-only")){

				$img = 0;
				if ($value[$key_]) {
					$img = 1;
				};

				$toggle_img_=$toggle_img;
				$toggle_off_img_=$toggle_off_img;
				if(array_key_exists(1,$this->tableType[$key_])){
					if(array_key_exists("on",$this->tableType[$key_][1][$key_])){
						$toggle_img_=array(
							0=>$this->tableType[$key_][1]["on"][0],
							1=>$this->tableType[$key_][1]["on"][1]                 
						);									
					};
					if(array_key_exists("off",$this->tableType[$key_][1])){
						$toggle_off_img_=array(
							0=>$this->tableType[$key_][1]["off"][0],
							1=>$this->tableType[$key_][1]["off"][1]
						);
					};
				};

				if($value["@write"]){

					if(is_array($toggle_img_[$img])){
						$cssMod="";
						if(strlen($toggle_img_[$img][1])){
							$cssMod="--".$toggle_img_[$img][1];
						};
						echo "<div class=\"xui-button ".$cssMod." --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui-button --primary --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};

				}else{

					if(is_array($toggle_img_[$img])){
						echo "<div class=\"xui-button --disabled --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui-button --disabled --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};
						
				};

			}else
			if($this->tableType[$key_][0]=="radio"){

				$img = 0;
				if ($value[$key_]) {
					$img = 1;
				};

				$toggle_img_=$toggle_img;
				$toggle_off_img_=$toggle_off_img;
				if(array_key_exists(1,$this->tableType[$key_])){
					if(array_key_exists("on",$this->tableType[$key_][1])){
						$toggle_img_=array(
							0=>$this->tableType[$key_][1]["on"][0],
							1=>$this->tableType[$key_][1]["on"][1]                 
						);									
					};
					if(array_key_exists("off",$this->tableType[$key_][1])){
						$toggle_off_img_=array(
							0=>$this->tableType[$key_][1]["off"][0],
							1=>$this->tableType[$key_][1]["off"][1]
						);
					};
				};

				if($value["@write"]){

					if(is_array($toggle_img_[$img])){
						$uid=$this->getUID();
						$cssMod="";
						if(strlen($toggle_img_[$img][1])){
							$cssMod="--".$toggle_img_[$img][1];
						};
						echo "<div id=\"".$uid."\" class=\"xui-button ".$cssMod." --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
						$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doRadio(\"".$this->instance."\",\"" . $value[$this->primaryKey] . "\",\"" . $key_ . "\");return false;};";
					} else {
						$uid=$this->getUID();
						echo "<div id=\"".$uid."\" class=\"xui-button --primary --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left\">";
						echo $toggle_img_[$img];
						echo "</div>";
						$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doRadio(\"".$this->instance."\",\"" . $value[$this->primaryKey] . "\",\"" . $key_ . "\");return false;};";
					};

				}else{

					if(is_array($toggle_img_[$img])){
						echo "<div class=\"xui-button --disabled --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui-button --disabled --circle --transparent xui-effect-ripple --icon --small  --size-xy24-22 float-left xyo-app-table -z-2\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};

				};				

			}else
			if($this->tableType[$key_][0]=="order"){
				echo "<div class=\"xui-form-input-group --small  float-left xyo-app-table --z-4\">";
			       		echo "<input type=\"text\"";
						echo " name=\"".$this->instanceV."order_" . $value[$this->primaryKey] . "\"";
						echo " value=\"" . $value[$key_] . "\"";
						echo " size=\"4\"></input>";
					$uid=$this->getUID();
					echo "<button id=\"".$uid."\" type=\"button\"><i class=\"lucide-chevron-up\"></i></button>";
					$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doOrderUp(\"".$this->instance."\",\"" . $value[$this->primaryKey] . "\",\"" . $key_ . "\");return false;};";
					$uid=$this->getUID();
					echo "<button id=\"".$uid."\" type=\"button\"><i class=\"lucide-chevron-down\"></i></button>";
					$script.="document.getElementById(\"".$uid."\").onclick=function(){XYO.Table.doOrderDown(\"".$this->instance."\",\"" . $value[$this->primaryKey] . "\",\"" . $key_ . "\");return false;};";
				echo "</div>";
			}else			
			if($this->tableType[$key_][0]=="value"){
				echo "<input type=\"text\"";
        			echo " name=\"".$this->instanceV."value_" . $value[$this->primaryKey] . "\"";
				echo " value=\"" . $value[$key_] . "\"";
				echo " size=\"8\"";
				echo " class=\"xui-form-text --small \"";
				echo " />";
			}else
			if($this->tableType[$key_][0]=="date"){
				$format=null;
				if(count($this->tableType[$key_])>1){
					$format=$this->tableType[$key_][1];
				};
				echo $this->formatDate($value[$key_],$format);
			}else
			if($this->tableType[$key_][0]=="datetime"){
				$format=null;
				if(count($this->tableType[$key_])>1){
					$format=$this->tableType[$key_][1];
				};
				echo $this->formatDateTime($value[$key_],$format);
			}else
			if($this->tableType[$key_][0]=="datetime-no-seconds"){
				$format=null;
				if(count($this->tableType[$key_])>1){
					$format=$this->tableType[$key_][1];
				};
				echo $this->formatDateTimeNoSeconds($value[$key_],$format);
			}else
			if($this->tableType[$key_][0]=="action"){
				$valueX=$value[$key_];

				if(count($this->tableType[$key_])>=3){
					if($this->tableType[$key_][2]=="datetime"){
						$format=null;
						if(count($this->tableType[$key_])>=4){
							$format=$this->tableType[$key_][3];
						};
						$valueX=$this->formatDateTime($value[$key_],$format);
					};
				};


				if($value["@write"]){
					$parameters = array();
					$p = "{";
					$first=false;
					foreach ($this->tableType[$key_][1] as $k => $v) {
						if($first){
							$p.=",";							
						}else{
							$first=true;
						};
						if (is_array($v)) {
							$p.="'".addcslashes(rawurlencode($k), "\\\'\"&\n\r<>")."'";
							$p.=":";
							$p.="'".addcslashes(rawurlencode($value[$v[0]]), "\\\'\"&\n\r<>")."'";
							$parameters[$k]=$value[$v[0]];
						}else{
							$p.="'".addcslashes(rawurlencode($k), "\\\'\"&\n\r<>")."'";
							$p.=":";
							$p.="'".addcslashes(rawurlencode($v), "\\\'\"&\n\r<>")."'";									
							$parameters[$k]=$v;
						};
					};
					$p .= "}";
					$uid=$this->getUID();
					echo "<a id=\"".$uid."\" class=\"xui-link\" href=\"".$this->requestUriThis($parameters)."\">" . $valueX . "</a>";
					$script.="document.getElementById(\"".$uid."\").onclick=function(){".$this->instanceV."callActionLink_".$key_."(".$p.");return false;};";
				}else{
					echo $valueX;
				};
			}else
			if($this->tableType[$key_][0]=="cmd-edit"){
				$valueX=$value[$key_];
				if(count($this->tableType[$key_])>=2){
					if($this->tableType[$key_][1]=="date"){
						$format=null;
						if(count($this->tableType[$key_])>=3){
							$format=$this->tableType[$key_][2];
						};
						$valueX=$this->formatDate($value[$key_],$format);
					};
					if($this->tableType[$key_][1]=="datetime"){
						$format=null;
						if(count($this->tableType[$key_])>=3){
							$format=$this->tableType[$key_][2];
						};
						$valueX=$this->formatDateTime($value[$key_],$format);
					};
				};

				if($value["@write"]){
					$uid=$this->getUID();
					echo "<a id=\"".$uid."\" class=\"xui-link\" href=\"".$this->requestUriThis(array("action"=>"form-edit","primary_key_value"=>$value[$this->primaryKey]))."\">" . $valueX . "</a>";
					$script.="document.getElementById(\"".$uid."\").onclick=function(){".$this->instanceV."cmdDialogEdit('".$value[$this->primaryKey]."');return false;};";
				}else{
					echo $valueX;
				};
			}else
			if($this->tableType[$key_][0]=="custom"){
				$this->viewKey=$key_;
				$this->viewId=$key;
				$this->viewPrimaryKey=$value[$this->primaryKey];
				$this->viewValue=$value[$key_];
				$this->viewRow=$value;
				if(is_array($this->tableType[$key_][1])){
					$parameters=array();
					$parameters[0]=$this->viewKey;
					$parameters[1]=$this->viewId;
					$parameters[2]=$this->viewValue;
					$parameters[3]=$this->tableType[$key_][1][1];
					$parameters[4]=$value;
					call_user_func_array($this->tableType[$key_][1][0],$parameters);
				}else{
					$this->generateView($this->tableType[$key_][1]);
				};
			}else{  	
				echo $value[$key_];
			};
		}else{
			echo $value[$key_];
		};
		echo "</td>";
	};
	echo "</tr>";
	if($this->hasDynamicRow_) {
		echo "<tr id=\"".$this->instanceV."dynamic_row_" . $value[$this->primaryKey] . "\" class=\"--dynamic-row xyo-app-table --z-5\" colspan=\"".count($this->tableHead)."\">";
		echo "</tr>";
	};
};
$this->generateView("table-view.row.last");
?>
</tbody>
<?php

$this->ejsBegin();
echo $script;
$this->ejsEnd();

