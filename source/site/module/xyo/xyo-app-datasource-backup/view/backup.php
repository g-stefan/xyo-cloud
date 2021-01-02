<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

echo "<forn name=\"x\" class=\"xui application-form\">";
$this->generateComponent("xui.box-1x1-begin");
$this->generateComponent("xui.panel-begin",array("title-text"=>$this->getFromLanguage("backup_title")));

?>

<div id="progress_bar1" class="xui progress-bar -success">
	<div class="xui _background"></div>
	<div class="xui _bar" id="progress_bar1_slider"></div>
	<div class="xui _label" id="progress_bar1_text">0%</div>
</div>

<br />

<div id="progress_bar2" class="xui progress-bar -info">
	<div class="xui _background"></div>
	<div class="xui _bar" id="progress_bar2_slider"></div>
	<div class="xui _label" id="progress_bar2_text">0%</div>
</div>

<br />

<div id="status_info"></div>


<?php 

$this->generateComponent("xui.panel-end");
$this->generateComponent("xui.box-1x1-end");
echo "</form>";

$this->ejsBegin(); ?>

function progressBarSetProcent1(procent){
	$("#progress_bar1_slider").css("width",procent+"%");
	$("#progress_bar1_text").html(procent+"%");
}

function progressBarSetProcent2(procent){
	$("#progress_bar2_slider").css("width",procent+"%");
	$("#progress_bar2_text").html(procent+"%");
}

function statusInfo(info){
	$("#status_info").html($("#status_info").html()+info+"<br/>");
}

<?php
$this->ejsEnd();

$connection = $this->getElementValue("connection", null);
$layer = $this->getElementValue("layer", null);
$date=$this->getParameter("date",null);
$stamp=$this->getParameter("stamp",null);

if($layer&&$connection){
	$js="$.ajax({type: \"POST\",url: \"";
	$js.=$this->requestUriThis(array(
		"action"=>"backup-step",
		"index1"=>0,
		"index2"=>0,
		"step2"=>64,
		"layer"=>$layer,
		"date"=>$date,
		"stamp"=>$stamp,
		"connection"=>$connection,
		"ajax-js"=>1
	));
	$js.="\",success:function(result){eval(result);}});";
	$this->setHtmlJsSource($js,"load");
}else{
	$js="";
	$js.="progressBarSetProcent1(100);";
	$js.="progressBarSetProcent2(100);";
	$js.="statusInfo(\"".$this->getFromLanguage("msg_done").".\");";	
	$this->setHtmlJsSource($js);
};

?>
<script>
	function doCommand(action){
        var el;
        var id;

        document.forms.<?php $this->eFormName(); ?>.elements.action.value=action;
        document.forms.<?php $this->eFormName(); ?>.submit();
        return false;
    }
</script>
<form name="<?php $this->eFormName(); ?>" method="POST" action="<?php $this->eFormAction(); ?>" >
	<input type="hidden" name="action" value="default" />
	<input type="hidden" name="<?php $this->eElementName("id"); ?>" value="<?php echo $this->eElementValue("id", 0); ?>" />
	<?php $this->eFormRequest(); ?>
</form>
<?php $this->generateView("view-return"); ?>
