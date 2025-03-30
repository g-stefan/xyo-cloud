<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ecssBegin();
echo ".--default.-ul-1{margin-top:2px;}";
$this->ecssEnd();

?>

<br>
<br>

<?php
$this->generateComponent("xui.box-1x1-begin");
$this->generateComponent("xui.panel-begin",array("title-text"=>"XYO Cloud - version ".$this->cloud->get("xyo_cloud_version")));
?>
<div class="prose">
Copyright (c) 2009-2025 Grigore Stefan &lt;<a href="mailto:g_stefan@yahoo.com" target="_blank">g_stefan@yahoo.com</a>&gt;<br/>
Created by Grigore Stefan &lt;<a href="mailto:g_stefan@yahoo.com" target="_blank">g_stefan@yahoo.com</a>&gt;<br/>
MIT License (MIT) &lt;<a href="http://opensource.org/licenses/MIT" target="_blank">http://opensource.org/licenses/MIT</a>&gt;<br/>
<br/>
This product includes PHP software, freely available from &lt;<a href="http://www.php.net/software/">http://www.php.net/software/</a>&gt;<br/>
<br/>
This product may include software endorsed with following licenses:
<ul class="--default --ul-1">
	<li>MIT License (MIT)</li>
	<li>PHP License version 3.01</li>
	<li>The BSD License</li>
	<li>GNU Lesser General Public License (GNU LGPL) version 2.1</li>
	<li>SIL OPEN FONT LICENSE Version 1.1</li>
	<li>Apache License, Version 2.0</li>
</ul>
Full text can be read <a href="<?php echo $this->site; ?>licenses.txt" target="_blank">here</a>.<br/>
<br />
This product includes icons created by Tango Desktop Project &lt;<a href="http://tango.freedesktop.org/" target="_blank">http://tango.freedesktop.org/</a>&gt;<br/>
<br />
</div>
<?php

$this->generateComponent("xui.panel-end");
$this->generateComponent("xui.box-1x1-end");

// ---

$list = $this->getGroup("about");
foreach ($list as $value) {	
	$this->generateViewFromModule($value,"about");
};

    