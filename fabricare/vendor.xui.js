// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2023-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: Unlicense

messageAction("vendor xui");

vendor =  "xui-" + Solution.vendor.xui;

Shell.mkdirRecursivelyIfNotExists("vendor");

if (Shell.fileExists("vendor/" + vendor + ".7z")) {
	return;
};

var vendorSourceGit = "https://github.com/g-stefan";
if (Shell.hasEnv("VENDOR_SOURCE_GIT")) {
	vendorSourceGit = Shell.getenv("VENDOR_SOURCE_GIT");
};

var vendorSourceAuth = "";
if (Shell.hasEnv("VENDOR_SOURCE_AUTH")) {
	vendorSourceAuth = Shell.getenv("VENDOR_SOURCE_AUTH");
};

var webLink = vendorSourceGit + "/xui/releases/download/v" + Solution.vendor.xui + "/" + vendor + ".7z";
exitIf(Shell.system("curl --insecure --location " + webLink + " " + vendorSourceAuth + " --output vendor/" + vendor + ".7z"));
if (Shell.getFileSize("vendor/" + vendor + ".7z") < 16384) {
	Shell.remove("vendor/" + vendor + ".7z");
	messageError("not found - "+webLink);
	return;
};
