<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Users");

$this->set("head.name", "Name");
$this->set("head.username", "Username");
$this->set("head.id", "Id");
$this->set("head.logged_at", "Logged at");
$this->set("head.enabled", "Enabled");
$this->set("head.logged_in", "Logged in");
$this->set("head.created_at", "Created at");
$this->set("head.action_at", "Action at");
$this->set("head.invisible","Invisible");

$this->set("select.xyo_user_group_any", "- user group -");
$this->set("select.xyo_language_any", "- language -");

$this->set("form.new_user", "New user");

$this->set("label.name", "Name");
$this->set("label.username", "Username");
$this->set("label.password1", "Password");
$this->set("label.password2", "Retype password");
$this->set("label.enabled", "Enabled");
$this->set("label.picture", "Picture");
$this->set("label.description", "Description");
$this->set("label.xyo_user_group_id", "Default user group");
$this->set("label.xyo_language_id", "Default language");
$this->set("label.invisible","Invisible");
$this->set("label.email","E-Mail");

$this->set("form.edit_user", "Edit user");
$this->set("form.title_user", "User");

$this->set("error.disable_this_user", "Unable to disable your's logged in user");
$this->set("error.save", "Save error");
$this->set("error.new_user_x_user_group_save", "Unable to save user default group");
$this->set("error.logout_this_user", "Can't logout yourself using that");
$this->set("error.delete_this_user", "Can't delete yourself");
$this->set("error.not_found", "Not found");

$this->set("info.logout_ok", "Logout successfully");

$this->set("select.invisible_any", "- invisible -");
$this->set("select.invisible_enabled", "yes");
$this->set("select.invisible_disabled", "no");

$this->set("select.xyo_user_group_none","- none -");
$this->set("select.xyo_language_none","- none -");
