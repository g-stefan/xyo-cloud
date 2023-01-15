// Created by Grigore Stefan <g_stefan@yahoo.com>
// Public domain (Unlicense) <http://unlicense.org>
// SPDX-FileCopyrightText: 2023 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: Unlicense

if (Script.isNil(Solution.hasGithub)) {
	return;
};

if (!Solution.hasGithub) {
	return;
};

messageAction("github-release");

var repository = Solution.name;
if (!Script.isNil(Solution.githubRepository)) {
	repository = Solution.githubRepository;
};

exitIf(!Shell.directoryExists("release"), "no release");

var version = getVersion();
var releaseName = repository + "-" + version;

Console.writeLn("Release v" + version);

Shell.system("git pull --tags origin main");
if (!Shell.system("git rev-parse --quiet \"v" + version + "\"")) {
	Console.writeLn("release v" + version + " already exists");
	return;
};
Shell.system("git tag -a \"v" + version + "\" -m \"v" + version + "\"");
Shell.system("git push --tags");
Console.writeLn("Create release v" + version);
Shell.system("github-release release --repo " + repository + " --tag \"v" + version + "\" --name \"v" + version + "\" --description \"Release\"");

// Wait a little for github to update release info
CurrentThread.sleep(1500);
Shell.system("github-release info --repo " + repository + " --tag \"v" + version + "\"");

var fileList = Shell.getFileList("release/*.7z");
for (var file of fileList) {
	Console.writeLn("Upload " + Shell.getFileName(file));
	Shell.system("github-release upload --repo " + repository + " --tag \"v" + version + "\" --name \"" + Shell.getFileName(file) + "\" --file \"" + file + "\"");
};

var fileList = Shell.getFileList("release/*.json");
for (var file of fileList) {
	Console.writeLn("Upload " + Shell.getFileName(file));
	Shell.system("github-release upload --repo " + repository + " --tag \"v" + version + "\" --name \"" + Shell.getFileName(file) + "\" --file \"" + file + "\"");
};
