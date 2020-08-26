<?php
//
// Copyright (c) 2020 Grigore Stefan <g_stefan@yahoo.com>
// Created by Grigore Stefan <g_stefan@yahoo.com>
//
// MIT License (MIT) <http://opensource.org/licenses/MIT>
//

defined("XYO_CLOUD") or die("Access is denied");

$select = array(
	"*" => $this->getFromLanguage("select.option_none"),
	"create" => $this->getFromLanguage("select.option_create"),
	"recreate" => $this->getFromLanguage("select.option_recreate"),
	"destroy" => $this->getFromLanguage("select.option_destroy")        
);

$this->setParameter("select.option", $select);
