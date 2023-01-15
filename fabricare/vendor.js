// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: Unlicense

messageAction("vendor");

vendor =  "xui-" + Solution.vendor.xui;

Shell.mkdirRecursivelyIfNotExists("vendor");

if (Shell.fileExists("vendor/" + vendor + ".7z")) {
	return;
};

var webLink = "https://github.com/g-stefan/xui/releases/download/v" + Solution.vendor.xui + "/" + vendor + ".7z";
exitIf(Shell.system("curl --insecure --location " + webLink + " --output vendor/" + vendor + ".7z"));
if (Shell.getFileSize("vendor/" + Project.vendor + ".7z") > 16) {
	return;
};
