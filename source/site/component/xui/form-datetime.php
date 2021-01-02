<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$element = $this->getArgument("element");

$maxlength= 1*$this->getArgument("maxlength");
if($maxlength==0){
	$maxlength="";
}else{
	$maxlength=" maxlength=\"".$maxlength."\"";
};

$year=date("Y");
$month=date("m")-1;
$day=date("d");
$hour="";
$minutes="";
$hasValue=false;
$value=$this->getElementValueString($element);		
if(strlen($value)){
	$hasValue=true;
	$year=substr($value,0,4);
	$month=1*substr($value,5,2)-1;
	$day=substr($value,8,2);
	$hour=substr($value,11,2);
	$minutes=substr($value,14,2);
};

$format = $this->getArgument("format",$this->cloud->get("locale_date_format",""));
if(strlen($format)){
	if($format=="Y-m-d"){
		$format="yyyy-mm-dd";
		$value=$this->getElementValueString($element);
		if(strlen($value)){
			$this->setElementValue($element,substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2).substr($value,10,strlen($value)));
		};
	};
	if($format=="Y/m/d"){
		$format="yyyy/mm/dd";
		$value=$this->getElementValueString($element);
		if(strlen($value)){
			$this->setElementValue($element,substr($value,0,4)."-".substr($value,5,2)."-".substr($value,8,2).substr($value,10,strlen($value)));
		};
	};
	if($format=="d-m-Y"){
		$format="dd-mm-yyyy";
		$value=$this->getElementValueString($element);
		if(strlen($value)){
			$this->setElementValue($element,substr($value,8,2)."-".substr($value,5,2)."-".substr($value,0,4).substr($value,10,strlen($value)));
		};
	};
	if($format=="d/m/Y"){
		$format="dd/mm/yyyy";
		$value=$this->getElementValueString($element);
		if(strlen($value)){
			$this->setElementValue($element,substr($value,8,2)."-".substr($value,5,2)."-".substr($value,0,4).substr($value,10,strlen($value)));
		};
	};
}else{
	$format="yyyy/mm/dd";
};

if($hasValue){
	$this->setHtmlJsSourceOrAjax("\$(\"#".$this->getElementId($element)."\").datepicker({autoClose:true,onlyTimepicker:false}).data(\"datepicker\").selectDate(new Date(".$year.",".$month.",".$day.",".$hour.",".$minutes."));","load");
}else{
	$this->setHtmlJsSourceOrAjax("\$(\"#".$this->getElementId($element)."\").datepicker({autoClose:true});","load");
};

?>
<label class="xui form-label<?php if($this->isElementError($element)){echo " -danger";}; ?>" for="<?php $this->eElementId($element); ?>"><?php $this->eLanguage("label." . $element); ?><?php if($this->isElementError($element)){echo " - "; $this->eElementError($element);}; ?></label>
<br>
<input type="text"<?php echo $maxlength; ?> class="xui form-text<?php if($this->isElementError($element)){echo " -danger";}; ?>" placeholder="" autocomplete="off"
	name="<?php $this->eElementName($element); ?>"
	value="<?php $this->eElementValue($element, ""); ?>"
	id="<?php $this->eElementId($element); ?>"
	data-date-format="<?php echo $format; ?>" data-timepicker="true" data-language="en" data-time-format="hh:ii"></input>
<?php if(strlen($format)){ ?>
	<input type="hidden" name="<?php $this->eElementName($element); ?>_format" value="<?php echo base64_encode($format); ?>"></input>
<?php }; ?>
<br>