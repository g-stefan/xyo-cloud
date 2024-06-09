// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2023-2024 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: Unlicense

Fabricare.include("vendor");

// ---

messageAction("make [" + Project.name + "]");

if (Shell.fileExists("temp/build.done.flag")) {
	return;
};

// ---

Shell.removeDirRecursivelyForce("output");
Shell.removeDirRecursivelyForce("temp");

Shell.mkdirRecursivelyIfNotExists("output");
Shell.mkdirRecursivelyIfNotExists("temp");

exitIf(Shell.system("7zr x vendor/xui-"+Solution.vendor.xui+".7z -otemp/xui"));
exitIf(!Shell.copyDirRecursively("temp/xui/vendor", "output/site/lib"));

Shell.mkdirRecursivelyIfNotExists("output/site/lib/xui");

Shell.copyFile("temp/xui/css/xui.complete.min.css","output/site/lib/xui/xui.complete.min.css");
Shell.copyFile("temp/xui/js/xui.complete.min.js","output/site/lib/xui/xui.complete.min.js");
Shell.copyFile("temp/xui/css/xui-animated-dna.min.css","output/site/lib/xui/xui-animated-dna.min.css");
Shell.copyFile("temp/xui/css/xui-dashboard-theme-2.min.css","output/site/lib/xui/xui-dashboard-theme-2.min.css");
Shell.copyFile("temp/xui/css/xui-dashboard-theme-3.min.css","output/site/lib/xui/xui-dashboard-theme-3.min.css");
Shell.copyFile("temp/xui/xui.version.vendor.txt output/site/xui.version.vendor.txt");

Shell.removeDirRecursivelyForce("temp/xui");

exitIf(!Shell.copyDirRecursively("source", "output"));

exitIf(Shell.system("xyo-version --no-bump --project=xyo-cloud --version-file=version.json --file-in=output/site/config/xyo-cloud.80.php --file-out=output/site/config/xyo-cloud.80.php.version"));
Shell.remove("output/site/config/xyo-cloud.80.php");
Shell.rename("output/site/config/xyo-cloud.80.php.version","output/site/config/xyo-cloud.80.php");

// ---

Shell.mkdirRecursivelyIfNotExists("temp");
Shell.filePutContents("temp/build.done.flag", "done");
