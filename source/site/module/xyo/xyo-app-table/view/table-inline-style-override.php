<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

?>

<?php $this->ecssBegin(); ?>
@media only screen and (min-width: 1280px) {

	.xui.box.-row {
		min-width: 480px;
		max-width: 1280px;
		margin-left: auto;
		margin-right: auto;
	}

	.xui.box.-x1x1 {
		min-width: 480px;
		max-width: 640px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 16px;
		padding-right: 16px;
	}

	.xui.box.-x1x2:nth-child(1) {
		float: none;
		width: auto;
		min-width: 480px;
		max-width: 640px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 16px;
		padding-right: 16px;		
	}

	.xui.box.-x1x2:nth-child(2) {
		float: none;
		width: auto;
		min-width: 480px;
		max-width: 640px;
		margin-left: auto;
		margin-right: auto;		
		padding-left: 16px;
		padding-right: 16px;
	}

	.xui.box.-x2x1 {
		min-width: 480px;
		max-width: 640px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 16px;
		padding-right: 16px;		
	}

	.xui.box.-x-900 {
		width: auto;
		min-width: 480px;
		max-width: 900px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 16px;
		padding-right: 16px;		
	}

	.xui.box.-space {
		height: 32px;
	}

}

@media only screen and (min-width: 1600px) {

	.xui.box.-row {
		max-width: 1280px;
		width: 1280px;
		margin-left: auto;
		margin-right: auto;
	}

	.xui.box.-x1x1 {
		max-width: 640px;
		width: 640px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 0px;
		padding-right: 0px;
	}

	.xui.box.-x1x2:nth-child(1) {
		float: left;
		max-width: 640px;
		width: 640px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 0px;
		padding-right: 8px;
	}

	.xui.box.-x1x2:nth-child(2) {
		float: right;
		max-width: 640px;
		width: 640px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 8px;
		padding-right: 0px;
	}

	.xui.box.-x2x1 {
		max-width: 1280px;
		width: 1280px;
		padding-left: 0px;
		padding-right: 0px;
	}

	.xui.box.-x-900 {
		max-width: 900px;
		width: 900px;
		margin-left: auto;
		margin-right: auto;
		padding-left: 16px;
		padding-right: 16px;
	}
}

<?php $this->ecssEnd(); ?>
