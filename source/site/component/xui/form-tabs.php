<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$prefixJS = $this->getArgument("prefixJS","");
$updateJS = $this->getArgument("updateJS","");
$baseClass = $this->getArgument("class","component-tabs");
$items = $this->getArgument("items",array());
$itemSize = $this->getArgument("item_size",240);
$activeItem = $this->getArgument("active_item",$this->getElementValue($element,$this->getArgument("default_active_item"))); 

?>
<input type="hidden" name="<?php $this->eElementName($element); ?>" value="<?php $this->eElementValue($element); ?>" id="<?php $this->eElementId($element); ?>" ></input>
<style>

.<?php echo $baseClass; ?> .<?php echo $baseClass; ?>_tab-content {
	display: block;
	opacity: 0;
	height: 0px;
	overflow: hidden;
	transition: opacity 0.3s ease-in;
}

.<?php echo $baseClass; ?> .<?php echo $baseClass; ?>_tab-content.-active {
	display: block;
	opacity: 1;
	height: auto;
	overflow: auto;
}

.<?php echo $baseClass; ?> .<?php echo $baseClass; ?>_tab-action {
	cursor: pointer;
}

.<?php echo $baseClass; ?> .<?php echo $baseClass; ?>_tab-item {
	flex-basis: <?php echo $itemSize; ?>px !important; 
	flex-grow: 0 !important;
}

</style>

<script>

function <?php echo $prefixJS; ?>_selectTab(e,tab){
	var el = document.getElementsByClassName("<?php echo $baseClass; ?>_tab-content");
	var k;

	for (k = 0; k < el.length; ++k) {
		el[k].className = el[k].className.replace(" -active", "");
	};

	el = document.getElementsByClassName("<?php echo $baseClass; ?>_tab-item");
	for (k = 0; k < el.length; ++k) {
		el[k].className = el[k].className.replace(" -active", "");
  	};

	el = document.getElementsByClassName("<?php echo $baseClass; ?>_tab-action");
	for (k = 0; k < el.length; ++k) {
		el[k].className = el[k].className.replace(" -selected", "");
  	}

	document.getElementById("<?php echo $baseClass; ?>_"+tab).className += " -active";
	e.currentTarget.parentElement.className += " -active";
	e.currentTarget.className += " -selected";
	document.getElementById("<?php $this->eElementId($element); ?>").value=tab;
};

</script>

<?php
echo "<div class=\"xui ".$baseClass."\">";
echo "<ul class=\"xui menu -tab\">";
	echo "<li class=\"xui _separator\"></li>";
	$first=true;
	foreach ($items as $key => $value) {
		$classActive="";
		$classSelected="";
		if($value["item"]==$activeItem||($first&&(strlen($activeItem)==0))){
			$first=false;
			$classActive=" -active";
			$classSelected=" -selected";
		};
		echo "<li class=\"xui ".$baseClass."_tab-item".$classActive."\">";
			echo "<div class=\"xui action -effect-ripple ".$baseClass."_tab-action ".$classSelected."\" onclick=\"".$prefixJS."_selectTab(event,'".$value["item"]."');\">";
				echo $value["icon"];
				echo "<span>".$value["text"]."</span>";
			echo "</div>";
		echo "</li>";
	};
	echo "<li class=\"xui _separator\" style=\"flex-grow: 1;\"></li>";
echo "</ul>";

foreach ($items as $key => $value) {
	$classActive="";
	if($value["item"]==$activeItem||($first&&(strlen($activeItem)==0))){
		$first=false;
		$classActive=" -active";
	};

	echo "<div class=\"xui ".$baseClass."_tab-content".$classActive."\" id=\"".$baseClass."_".$value["item"]."\">";
		$this->generateView($value["item"]);
	echo "</div>";
};

echo "</div>";
