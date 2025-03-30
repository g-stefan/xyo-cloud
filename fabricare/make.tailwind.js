// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2023-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: Unlicense

messageAction("make [" + Project.name + ".tailwind]");

// ---

runInPath("temp", function() {
	if (!Shell.directoryExists("node_modules")) {
		exitIf(Shell.system("7z x -aoa ../archive/vendor.7z"));
	};
});

// ---

Shell.remove("output/site/lib/xyo-cloud.css");
Shell.copy("source/site/lib/xyo-cloud.css", "temp/xyo-cloud.css");
runInPath("temp", function() {
	Shell.system("npx @tailwindcss/cli  -i ./xyo-cloud.css -o ../output/site/lib/xyo-cloud.min.css --minify");
});

// ---