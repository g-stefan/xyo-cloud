<?php                                                                   
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

?>
<thead>
	<tr>
<?php

foreach ($this->tableHead as $key => $value) {
	$hasSort=false;

	if ($key === "#") {
		echo "<th class=\"xui _select -important\">";
	}else{
		$cssClass="xui";
					
		$hasSort=false;
		if(array_key_exists($key, $this->tableSort)){
			if(strlen($sort_img[$sortState[$key]])){
				$cssClass.=" _sort";
				$hasSort=true;
			};
		};
										
		if (array_key_exists($key, $this->tableType)) {
			if (($this->tableType[$key][0]=="order")||($this->tableType[$key][0]=="value")) {							
				if($hasSort){
					$cssClass.=" -action";
				} else {
					$cssClass.=" _action";
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
			$cssClass.=" -important";
		};
			
		echo "<th class=\"".$cssClass." -field-".$key."\">";
	};
	
	if ($key === "#") {
		echo "<div class=\"xui form-checkbox -box\">";
			echo "<input type=\"checkbox\" id=\"".$this->instanceV."id_0\" name=\"".$this->instanceV."id_0\" value=\"0\" onchange=\"XYO.Table.setCheckboxState('".$this->instance."',this);\" onclick=\"XYO.Table.setCheckboxState('".$this->instance."',this);\">";
			echo "<label for=\"".$this->instanceV."id_0\"></label>";
		echo "</div>";
		echo "</th>";
		continue;
	};

	if (array_key_exists($key, $this->tableSort)){
		echo "<span style=\"cursor:pointer;\" onclick=\"XYO.Table.doSort('".$this->instance."','".$key."','".$sortNextState[$sortState[$key]]."');return false;\">";
		$this->eLanguage($value);
		echo "</span>";
	}else{
		$this->eLanguage($value);
	};

	if (array_key_exists($key, $this->tableType)) {
		if (($this->tableType[$key][0]=="order")||($this->tableType[$key][0]=="value")) {
			echo "<div class=\"xui button -transparent -effect-ripple -primary -icon -small -size-xy28\" onclick=\"XYO.Table.doOrderSave('".$this->instance."','" . $key . "');return false;\">";
				echo "<i class=\"material-icons\">save</i>";
			echo "</div>";
		};
	};
				 
	if ($hasSort){					
		if(is_array($sort_img[$sortState[$key]])){
			echo "<div class=\"xui button -transparent -effect-ripple -".$sort_img[$sortState[$key]][1]." -icon -small -size-xy28 -circle\" onclick=\"XYO.Table.doSort('".$this->instance."','".$key."','".$sortNextState[$sortState[$key]]."');return false;\">";
				echo $sort_img[$sortState[$key]][0];	
			echo "</div>";
		}else{
			echo "<div class=\"xui button -transparent -effect-ripple -secondary -icon -small -size-xy28 -circle\" onclick=\"XYO.Table.doSort('".$this->instance."','".$key."','".$sortNextState[$sortState[$key]]."');return false;\">";
				echo $sort_img[$sortState[$key]];	
			echo "</div>";
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
	echo "<td class=\"xui -align-center -important -bg-danger-1\" colspan=\"".count($this->tableHead)."\" style=\"color:#FFF;\">";
		$this->eLanguage("error.datasource_not_found");
		echo ": ".$this->applicationDataSource;
	echo "</td>";
	echo "</tr>";
};

if(($this->ds)&&(count($this->viewData)==0)){
	echo "<tr>";
	echo "<td class=\"xui -align-center -fg-aluminium-3 -important\" colspan=\"".count($this->tableHead)."\">";
		$this->eLanguage("info.no_records");
	echo "</td>";
	echo "</tr>";
};

$recordId=0;
foreach ($this->viewData as $key => $value) {
       	echo "<tr id=\"".$this->instanceV."row_" . $value[$this->primaryKey] . "\" class=\"-visible\">";
	foreach ($this->tableHead as $key_ => $value_) {

		if ($key_ === "#") {
			echo "<td class=\"xui _select -important\">";
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
				$classImportant="-important";
			};

			if (array_key_exists($key_, $this->tableType)) {
				if(($this->tableType[$key_][0]=="toggle")||
					($this->tableType[$key_][0]=="radio")||
					($this->tableType[$key_][0]=="toggle-read-only")||
					($this->tableType[$key_][0]=="radio-read-only")){
						$classImportant.=" _action";
				};
			};

			echo "<td class=\"xui ".$classImportant." -field-".$key_."\">";
		};

		if ($key_ === "#") {
			++$recordId;
			if($value["@write"]){
		        	echo "<div class=\"xui form-checkbox -box -small\"><input type=\"checkbox\" id=\"".$this->instanceV."cbox_" . $recordId . "\"  name=\"".$this->instanceV."id_" . $value[$this->primaryKey] . "\" value=\"" . $value[$this->primaryKey] . "\" ></input><label for=\"".$this->instanceV."cbox_" . $recordId . "\"></label></div>";
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
						echo "<div class=\"xui button -".$toggle_img_[$img][1]." -transparent -effect-ripple -icon -small -size-xy24-22 -left\" onclick=\"XYO.Table.doToggle('".$this->instance."','" . $value[$this->primaryKey] . "','" . $key_ . "',".$forceCommand.");return false;\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui button -primary -transparent -effect-ripple -icon -small -size-xy24-22 -left\" onclick=\"XYO.Table.doToggle('".$this->instance."','" . $value[$this->primaryKey] . "','" . $key_ . "',".$forceCommand.");return false;\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};

				}else{
                        
					if(is_array($toggle_img_[$img])){
						echo "<div class=\"xui button -disabled -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui button -disabled -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
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
						echo "<div class=\"xui button -".$toggle_img_[$img][1]." -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui button -primary -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};

				}else{

					if(is_array($toggle_img_[$img])){
						echo "<div class=\"xui button -disabled -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui button -disabled -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
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
						echo "<div class=\"xui button -".$toggle_img_[$img][1]." -transparent -effect-ripple -icon -small -size-xy24-22 -left\" onclick=\"XYO.Table.doRadio('".$this->instance."','" . $value[$this->primaryKey] . "','" . $key_ . "');return false;\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui button -primary -transparent -effect-ripple -icon -small -size-xy24-22 -left\" onclick=\"XYO.Table.doRadio('".$this->instance."','" . $value[$this->primaryKey] . "','" . $key_ . "');return false;\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};

				}else{

					if(is_array($toggle_img_[$img])){
						echo "<div class=\"xui button -disabled -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
						echo $toggle_img_[$img][0];
						echo "</div>";
					} else {
						echo "<div class=\"xui button -disabled -transparent -effect-ripple -icon -small -size-xy24-22 -left\" style=\"cursor:default;\">";
						echo $toggle_img_[$img];
						echo "</div>";
					};

				};				

			}else
			if($this->tableType[$key_][0]=="order"){
				echo "<div class=\"xui form-input-group -small -left\" style=\"min-width: 130px;\">";
			       		echo "<input type=\"text\"";
						echo " name=\"".$this->instanceV."order_" . $value[$this->primaryKey] . "\"";
						echo " value=\"" . $value[$key_] . "\"";
						echo " size=\"4\"></input>";
					echo "<button type=\"button\" onclick=\"XYO.Table.doOrderUp('".$this->instance."','" . $value[$this->primaryKey] . "','" . $key_ . "');return false;\"><i class=\"material-icons\">expand_less</i></button>";
					echo "<button type=\"button\" onclick=\"XYO.Table.doOrderDown('".$this->instance."','" . $value[$this->primaryKey] . "','" . $key_ . "');return false;\"><i class=\"material-icons\">expand_more</i></button>";
				echo "</div>";
			}else			
			if($this->tableType[$key_][0]=="value"){
				echo "<input type=\"text\"";
        			echo " name=\"".$this->instanceV."value_" . $value[$this->primaryKey] . "\"";
				echo " value=\"" . $value[$key_] . "\"";
				echo " size=\"8\"";
				echo " class=\"xui form-text -small\"";
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
					echo "<a class=\"xui link\" href=\"".$this->requestUriThis($parameters)."\" onclick=\"".$this->instanceV."callActionLink_".$key_."(".$p.");return false;\">" . $valueX . "</a>";
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
					echo "<a class=\"xui link\" href=\"".$this->requestUriThis(array("action"=>"form-edit","primary_key_value"=>$value[$this->primaryKey]))."\" onclick=\"".$this->instanceV."cmdDialogEdit('".$value[$this->primaryKey]."');return false;\">" . $valueX . "</a>";
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
		echo "<tr id=\"".$this->instanceV."dynamic_row_" . $value[$this->primaryKey] . "\" class=\"xui -dynamic-row\" style=\"display:none;\" colspan=\"".count($this->tableHead)."\">";
		echo "</tr>";
	};
};
$this->generateView("table-view.row.last");
?>
</tbody>
