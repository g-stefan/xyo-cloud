<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$list_layer = array(
	"xyo"=>"xyo",
	"csv"=>"csv",
	"sqlite"=>"sqlite",
	"mysql"=>"mysql",
	"mysqli"=>"mysqli",
	"postgresql"=>"postgresql"
);

$this->setParameter("select.layer",$list_layer);
