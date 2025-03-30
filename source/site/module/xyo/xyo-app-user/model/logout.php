<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->ds->clear();
$this->ds->{$this->primaryKey} = $this->primaryKeyValue;
for ($this->ds->load(); $this->ds->isValid(); $this->ds->loadNext()) {
	if ($this->ds->id == $this->user->info->id) {
		$this->setError("error.logout_this_user");
		continue;
	};
	$this->ds->session = "";
	$this->ds->action_at = "NOW";
	$this->ds->action = 0;
	$this->ds->logged_in = 0;
	$this->ds->save();
};

if (!$this->isError()) {
	$this->setAlert("info.logout_ok");
};
