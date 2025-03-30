<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Utilizatori");

$this->set("head.name", "Nume");
$this->set("head.username", "Utilizator");
$this->set("head.id", "Id");
$this->set("head.logged_at", "Ultimul login");
$this->set("head.enabled", "Activat");
$this->set("head.logged_in", "Este logat");
$this->set("head.created_at", "Creat");
$this->set("head.action_at", "Actiune");
$this->set("head.invisible","Invizibil");

$this->set("select.xyo_user_group_any", "- grup utilizator -");
$this->set("select.xyo_language_any", "- limba -");

$this->set("form.new_user", "Utilizator nou");

$this->set("label.name", "Nume");
$this->set("label.username", "Nume utilizator");
$this->set("label.password1", "Parola");
$this->set("label.password2", "Introduce parola din nou");
$this->set("label.enabled", "Activat");
$this->set("label.picture", "Poza");
$this->set("label.description", "Descriere");
$this->set("label.xyo_user_group_id", "Grup utilizator implicit");
$this->set("label.xyo_language_id", "Limba implicita");
$this->set("label.invisible","Invizibil");
$this->set("label.email","E-Mail");

$this->set("form.edit_user", "Modifica utilizator");
$this->set("form.title_user", "Utilizator");

$this->set("error.disable_this_user", "Nu pot dezactiva utilizatorul tau cu care esti logat acum");
$this->set("error.save", "Eroare salvare");
$this->set("error.new_user_x_user_group_save", "Nu am putut salva grupul implicit al utilizatorului");
$this->set("error.logout_this_user", "Nu te poti deloga singur folosit aceast comanda");
$this->set("error.delete_this_user", "Nu te poti sterge singur");
$this->set("error.not_found", "Nu a fost gasit");

$this->set("info.logout_ok", "Delogare cu succes");

$this->set("select.invisible_any", "- invizibil-");
$this->set("select.invisible_enabled", "da");
$this->set("select.invisible_disabled", "nu");

$this->set("select.xyo_user_group_none","- nici unul -");
$this->set("select.xyo_language_none","- nici una -");
