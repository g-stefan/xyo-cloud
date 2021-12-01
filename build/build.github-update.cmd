@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\build\build.config.cmd

SETLOCAL ENABLEDELAYEDEXPANSION

echo -^> github-update %PRODUCT_NAME%

git fetch --prune --prune-tags
git add --all
git commit -m "Update"
git push
