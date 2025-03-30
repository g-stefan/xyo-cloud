<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");

$maxlength= 1*$this->getArgument("maxlength");
if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};
$readonly = $this->getArgument("readonly","");

$year=date("Y");
$month=date("m")-1;
$day=date("d");
$hour="";
$minutes="";
$hasValue=false;
$value=$this->getElementValueString($element);		
if(strlen($value)){
	$hasValue=true;
	$hour=substr($value,0,2);
	$minutes=substr($value,3,2);
};

$format = $this->getArgument("format",$this->cloud->get("locale_time_format",""));
if(strlen($format)){
	if($format=="H:i:s"){
		$format="HH:mm";
		$value=$this->getElementValueString($element);		
		if(strlen($value)){
			$this->setElementValue($element,substr($value,0,2).":".substr($value,3,2));
		};
	};
}else{
	$format="HH:mm";
};

$airDatePicker="new AirDatepicker(\"#".$this->getElementId($element)."\",{autoClose:true,timepicker:true,onlyTimepicker:true,locale:AirDatepickerLocaleEN,timeFormat:\"".$format."\"})";
if($hasValue){
	$this->setHtmlJsSourceOrAjax("(".$airDatePicker.").selectDate(new Date(".$year.",".$month.",".$day.",".$hour.",".$minutes."),{updateTime:true});","load");
}else{
	$this->setHtmlJsSourceOrAjax($airDatePicker.";","load");
};

$classReadonly="";
if(($readonly == 1) ||  ($readonly == "true")){
	$readonly=" readonly=\"readonly\"";
	$classReadonly=" --readonly";
}else{
	$readonly="";
};

?>
<label class="xui-form-label<?php if($this->isElementError($element)){echo " --danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<input type="text"<?php echo $maxlength; ?> class="xui-form-text<?php if($this->isElementError($element)){echo " --danger";}; echo $classReadonly; ?>" placeholder="" autocomplete="off"
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>" <?php echo $readonly; ?> ></input>
<?php if(strlen($format)){ ?>
	<input type="hidden" name="<?php $this->eElementName($element); ?>_format" value="<?php echo base64_encode($format); ?>"></input>
<?php }; ?>
<br>