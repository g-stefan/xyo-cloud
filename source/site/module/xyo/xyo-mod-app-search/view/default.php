<?php
//
// Copyright (c) 2020-2021 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

if($this->cloud->hasApplication()) {
	$modApp=&$this->cloud->getModule($this->cloud->getApplication());
	if($modApp instanceof xyo_mod_Application) {
		if($modApp->hasSearch()) {
			echo "<div class=\"xui\" id=\"application_search_super\">";
				echo "<form name=\"application_search\" id=\"application_search_form\" onsubmit=\"XYO.Application.doSearch();return false;\">";
					$this->eFormRequestCsrf();
					echo "<div class=\"xui form-text -icon-right\">";
					echo "<input type=\"text\" name=\"search\" value=\"\" size=\"32\" placeholder=\"Search\" id=\"application_search\"></input>";
					echo "<i class=\"material-icons\">search</i>";
					echo "</div>";
				echo "</form>";
			echo "</div>";
		};
	};
};
