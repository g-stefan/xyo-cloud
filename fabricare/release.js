// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2023-2024 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: Unlicense

if (!Script.isNil(Solution.hasRelease)) {
	if (!Solution.hasRelease) {
		return;
	};
};

// ---

messageAction("release");

function commandFix(cmd) {
	if (Platform.name.indexOf("mingw") >= 0) {
		return "C:\\msys64\\usr\\bin\\sh -c \"" + cmd.replace("\"", "\\\"") + "\"";
	};
	return cmd;
};

var p7zipCompress = "7z a -mx9 -mmt4 -r- -w. -y -t7z";
var pathSeparator = "/";
if (OS.isWindows()) {
	if (Platform.name.indexOf("mingw") >= 0) {
		pathSeparator = "/";
	} else {
		p7zipCompress += " -sse";
		pathSeparator = "\\";
	};
};

var version = getVersion();

var releasePrefix = Solution.name;
if (!Script.isNil(Solution.releaseName)) {
	releasePrefix = Solution.releaseName;
};

var releaseName = releasePrefix + "-" + version;
var jsonFilename = "release" + pathSeparator + releasePrefix + "-" + version + ".sha512.json";
var releaseDev = true;
var releaseBin = true;
var releaseOutput = false;

if (!Script.isNil(Solution.releaseDev)) {
	releaseDev = Solution.releaseDev;
};
if (!Script.isNil(Solution.releaseBin)) {
	releaseBin = Solution.releaseBin;
};
if (!Script.isNil(Solution.releaseOutput)) {
	releaseOutput = Solution.releaseOutput;
};

if (releaseOutput) {
	releaseDev = false;
	releaseBin = false;
};

Shell.mkdirRecursivelyIfNotExists("release");

// Release output
if (releaseOutput) {
	if (!Shell.fileExists("release" + pathSeparator + releaseName + ".7z")) {
		if (Shell.directoryExists("output")) {
			runInPath("output", function() {
				exitIf(Shell.system(commandFix(p7zipCompress + " \".." + pathSeparator + "release" + pathSeparator + releaseName + ".7z\" .")));
			});
		};
		if (Shell.fileExists("release" + pathSeparator + releaseName + ".7z")) {
			var json = {};
			var jsonFile = Shell.fileGetContents(jsonFilename);
			if (jsonFile) {
				json = JSON.decode(jsonFile);
				if (Script.isNil(json)) {
					json = {};
				};
			};
			json[releaseName + ".7z"] = SHA512.fileHash("release" + pathSeparator + releaseName + ".7z");
			Shell.filePutContents(jsonFilename, JSON.encodeWithIndentation(json));
		};
	};
};
