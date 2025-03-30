<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");
$value = $this->getElementValue($element,"");
//
//
//
$fileName="";
$offsetX=0;
$offsetY=0;
$zoom=1;
$viewX=$this->getArgument("view_x",320);
$viewY=$this->getArgument("view_y",240);
$imageWidth=$viewX;
$imageHeight=$viewY;
$emptySet=true;
//
//
//
if(strlen($value)>0){
	$list=str_getcsv($value,",","\"","\\");
	$fileName=$list[0];
	$emptySet=true;
	if(count($list)>1){
		$emptySet=false;
		$offsetX=$list[1];
		$offsetY=$list[2];
		$zoom=$list[3];
		$imageWidth=$list[4];
		$imageHeight=$list[5];
		//$viewX=$list[6];
		//$viewY=$list[7];
	};
};
//
//
//
if(1*$zoom==0){
	$zoom=1;
};

$maxZoom = $this->getArgument("max_zoom",3);

$uidDelete = $this->getUID();
$uidClear = $this->getUID();

$src="";
$src.="var ".$this->getElementId($element)."_first=true;";
if($emptySet){
	$src.="var ".$this->getElementId($element)."_emptySet=true;";
}else{
	$src.="var ".$this->getElementId($element)."_emptySet=false;";
};

$src.="\$(\"#".$this->getElementId($element)."_component\").cropit({ imageBackground: true, allowDragNDrop: false, imageBackgroundBorderWidth: 16, maxZoom: ".$maxZoom." ";
$src.=", onOffsetChange: function(offset){";
$src.="var offset=\$(\"#".$this->getElementId($element)."_component\").cropit(\"offset\");";
$src.="document.getElementById(\"".$this->getElementId($element)."_offset_x\").value=offset.x;";
$src.="document.getElementById(\"".$this->getElementId($element)."_offset_y\").value=offset.y;";
$src.="}";
$src.=", onZoomChange: function(zoom){";
$src.="document.getElementById(\"".$this->getElementId($element)."_zoom\").value=zoom;";
$src.="}";
$src.=", onImageLoaded: function(){";
$src.="if(".$this->getElementId($element)."_first){".$this->getElementId($element)."_first=false;";
$src.="if(!".$this->getElementId($element)."_emptySet){";
$src.="\$(\"#".$this->getElementId($element)."_component\").cropit(\"zoom\", ".$zoom.");";
$src.="\$(\"#".$this->getElementId($element)."_component\").cropit(\"offset\",{ x: ".$offsetX.", y: ".$offsetY." });";
$src.="}";
$src.="}";
$src.="var imageSize=\$(\"#".$this->getElementId($element)."_component\").cropit(\"imageSize\");";
$src.="document.getElementById(\"".$this->getElementId($element)."_width\").value=imageSize.width;";
$src.="document.getElementById(\"".$this->getElementId($element)."_height\").value=imageSize.height;";
$src.="}";
$src.="});";
if(strlen($fileName)>0){
	if(substr($fileName, 0, strlen("http")) === "http"){
		$src.="var ".$this->getElementId($element)."_filename=\"".$fileName."\";";
		$src.="\$(\"#".$this->getElementId($element)."_component\").cropit(\"imageSrc\",\"".$fileName."\");";
	}else{
		$src.="var ".$this->getElementId($element)."_filename=\"".$this->site.$fileName."\";";
		$src.="\$(\"#".$this->getElementId($element)."_component\").cropit(\"imageSrc\",\"".$this->site.$fileName."\");";
	};
}else{
	$src.="var ".$this->getElementId($element)."_filename=\"\";";
};

$src.="document.getElementById(\"".$uidDelete."\").onclick=function(){";
$src.="$(\"#".$this->getElementId($element)."_delete\").val(1);";
$src.=$this->getElementId($element)."_filename=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAZdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjAuMTnU1rJkAAABSklEQVR4Xu3IMQEAAAyDsPk33RnAARx5ctsihhkPzHhgxgMzHpjxwIwHZjww44EZD8x4YMYDMx6Y8cCMB2Y8MOOBGQ/MeGDGAzMemPHAjAdmPDDjgRkPzHhgxgMzHpjxwIwHZjww44EZD8x4YMYDMx6Y8cCMB2Y8MOOBGQ/MeGDGAzMemPHAjAdmPDDjgRkPzHhgxgMzHpjxwIwHZjww44EZD8x4YMYDMx6Y8cCMB2Y8MOOBGQ/MeGDGAzMemPHAjAdmPDDjgRkPzHhgxgMzHpjxwIwHZjww44EZD8x4YMYDMx6Y8cCMB2Y8MOOBGQ/MeGDGAzMemPHAjAdmPDDjgRkPzHhgxgMzHpjxwIwHZjww44EZD8x4YMYDMx6Y8cCMB2Y8MOOBGQ/MeGDGAzMemPHAjAdmPDDjgRkPzHhgxgMzHpjxwIwHZix2DyeSSzItWkMzAAAAAElFTkSuQmCC\";";
$src.="document.getElementById(\"".$this->getElementId($element)."\").value=null;";
$src.="$(\"#".$this->getElementId($element)."\").trigger(\"change\");";
$src.="\$(\"#".$this->getElementId($element)."_component\").cropit(\"imageSrc\",".$this->getElementId($element)."_filename);";
$src.="};";

$src.="document.getElementById(\"".$uidClear."\").onclick=function(){";
$src.="document.getElementById(\"".$this->getElementId($element)."\").value=null;";
$src.="$(\"#".$this->getElementId($element)."\").trigger(\"change\");";
$src.="\$(\"#".$this->getElementId($element)."_component\").cropit(\"imageSrc\",".$this->getElementId($element)."_filename);";
$src.="};";

$this->setHtmlJsSourceOrAjax($src,"load");

$this->ecssBegin();
?>

#<?php $this->eElementId($element); ?>_component .cropit-preview{
	margin-left: auto  !important;
	margin-right: auto  !important;
	width: <?php echo $viewX; ?>px  !important;
	height: <?php echo $viewY; ?>px  !important;
	border: 16px solid #EEEEEE  !important;
}
.--form-image.--div-1{
	height:48px  !important;
	position: relative  !important;
}
.--form-image.--icon-1{
	font-size:24px !important;
	line-height: 48px !important;
	vertical-align: middle !important;
}
.--form-image.--icon-2{
	font-size:48px !important;
	line-height: 48px !important;
	vertical-align: middle  !important;
}
.--form-image.--link{
	margin: 3px 3px 3px 3px !important;
}

<?php $this->ecssEnd(); ?>

<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<div class="xui-form-image" id="<?php $this->eElementId($element); ?>_component">
<div class="xui-form-image_image">
		<div class="cropit-preview"></div>
		<div class="--form-image --div-1">
			<i class="lucide-image --form-image --icon-1"></i><input type="range" class="cropit-image-zoom-input"></input><i class="lucide-image --form-image --icon-2"></i>
		</div>
		<div class="clear-both"></div>
</div>
<?php if(strlen($fileName)){
	if(substr($fileName, 0, strlen("http")) === "http"){ ?>
		<a href="<?php echo $fileName; ?>" target="_blank" class="xui-form-image_link xui-button --icon --success --size-x32 --circle --transparent xui-effect-ripple --form-image --link"><i class="lucide-image"></i></a>
<?php	}else{ ?>
		<a href="<?php echo $this->site.$fileName; ?>" target="_blank" class="xui-form-image_link xui-button --icon --success --size-x32 --circle --transparent xui-effect-ripple  --form-image --link"><i class="lucide-image"></i></a>
<?php	}; ?>
<?php }; ?>
<div class="xui-form-image_delete xui-button --icon --danger --size-x32 --circle --transparent xui-effect-ripple  --form-image --link" id="<?php echo $uidDelete; ?>"><i class="lucide-trash"></i></div>
<div class="xui-form-file">
<input type="file" name="<?php $this->eElementName($element); ?>" id="<?php $this->eElementId($element); ?>" class="xui-form-file_input cropit-image-input" accept="image/*"></input>
<label for="<?php $this->eElementId($element); ?>" class="xui-button --icon-left --outline"><i class="lucide-upload"></i><span>Browse ...</span></label>
<button type="button" class="xui-button --icon --secondary --outline" id="<?php echo $uidClear; ?>"><i class="lucide-x"></i></button>
</div>
</div>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_delete"
	value="0"
	id="<?php $this->eElementId($element); ?>_delete" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_value"
	value="<?php $this->eElementValue($element); ?>" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_file"
	value="<?php echo $fileName; ?>" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_offset_x"
	value="<?php echo $offsetX; ?>"
	id="<?php $this->eElementId($element); ?>_offset_x" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_offset_y"
	value="<?php echo $offsetY; ?>"
	id="<?php $this->eElementId($element); ?>_offset_y" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_zoom"
	value="<?php echo $zoom; ?>"
	id="<?php $this->eElementId($element); ?>_zoom" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_width"
	value="<?php echo $imageWidth; ?>"
	id="<?php $this->eElementId($element); ?>_width" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_height"
	value="<?php echo $imageHeight; ?>"
	id="<?php $this->eElementId($element); ?>_height" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_view_x"
	value="<?php echo $viewX; ?>"
	id="<?php $this->eElementId($element); ?>_view_x" ></input>
<input type="hidden"
	name="<?php $this->eElementName($element); ?>_view_y"
	value="<?php echo $viewY; ?>"
	id="<?php $this->eElementId($element); ?>_view_y" ></input>
<div class="clear-both h-4"></div>
