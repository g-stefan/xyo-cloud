@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call build\build.config.cmd

SETLOCAL ENABLEDELAYEDEXPANSION

echo -^> github-release-keep-last-3 %PRODUCT_NAME%

if not exist temp\ mkdir temp
if exist temp\github-release-delete.cmd del /Q temp\github-release-delete.cmd
github-release info --repo %PROJECT% --json > temp\github-release-info.json
quantum-script build\build.github-release-keep-last-3.js
if exist temp\github-release-delete.cmd call temp\github-release-delete.cmd
