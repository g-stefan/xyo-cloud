<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$this->set("application.title", "Tabela");

$this->set("head.enabled", "Activat");
$this->set("label.enabled", "Activat");
$this->set("select.enabled_any", "- activat -");
$this->set("select.enabled_default_disabled", "- nu -");
$this->set("select.enabled_enabled", "da");
$this->set("select.enabled_disabled", "nu");

$this->set("head.allow", "Permit");
$this->set("label.allow", "Permit");
$this->set("select.allow_any", "- permit -");
$this->set("select.allow_default_disabled", "- nu -");
$this->set("select.allow_enabled", "da");
$this->set("select.allow_disabled", "nu");

$this->set("select.count_5", "5");
$this->set("select.count_10", "10");
$this->set("select.count_15", "15");
$this->set("select.count_25", "25");
$this->set("select.count_50", "50");
$this->set("select.count_100", "100");
$this->set("select.count_all", "tot");

$this->set("title.btn_go_first", "Inceput");
$this->set("title.btn_go_previous", "Inapoi");
$this->set("title.btn_go_next", "Urmator");
$this->set("title.btn_go_last", "Ultimul");

$this->set("error.unable_to_delete", "Nu pot sterge");
$this->set("error.save", "Eroare salvare");
$this->set("info.delete_ok", "Sters cu succes");

$this->set("error.is_empty","este gol");
$this->set("error.already_exists","deja exista");

$this->set("form.title_delete","Sterge");
$this->set("label.button_delete","Sterge");
$this->set("delete.this_and_many_more","... si mai multe");

$this->set("label.button_new","Aplica");
$this->set("label.button_edit","Aplica");
$this->set("label.button_filter","Aplica");

$this->set("search", "Cauta");

$this->set("label.filter","Filtreaza");
$this->set("form.title_filter","Filtreaza");

$this->set("info.items","articole");
$this->set("info.pages","pagini");
$this->set("info.total_items","total articole");

$this->set("info.no_records","- nu sunt inregistrari -");

$this->set("cancel","Anuleaza");
$this->set("done","Finalizat");

$this->set("select.all", "- tot -");
