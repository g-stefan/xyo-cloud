// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2023-2025 Grigore Stefan <g_stefan@yahoo.com>
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

Shell.copyFile("temp/xui/release/xui.bundle.css","temp/xui.bundle.css");
Shell.copyFile("temp/xui/release/xui.bundle.min.js","output/site/lib/xui.bundle.min.js");

Shell.removeDirRecursivelyForce("temp/xui");

exitIf(!Shell.copyDirRecursively("source", "output"));

exitIf(Shell.system("xyo-version --no-bump --project=xyo-cloud --version-file=version.json --file-in=output/site/config/xyo-cloud.80.php --file-out=output/site/config/xyo-cloud.80.php.version"));
Shell.remove("output/site/config/xyo-cloud.80.php");
Shell.rename("output/site/config/xyo-cloud.80.php.version","output/site/config/xyo-cloud.80.php");

// ---
Fabricare.include("make.tailwind");
// ---

Shell.mkdirRecursivelyIfNotExists("temp");
Shell.filePutContents("temp/build.done.flag", "done");
