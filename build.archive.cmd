@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call build.config.cmd

SETLOCAL ENABLEDELAYEDEXPANSION
FOR /F "tokens=* USEBACKQ" %%F IN (`xyo-version --no-bump --get "--version-file=%PROJECT%.version.ini" %PROJECT%`) DO (
	SET VERSION=%%F
)

if exist archive/%PROJECT%-%VERSION%.7z del /Q /F archive\%PROJECT%-%VERSION%.7z

move release %PROJECT%-%VERSION%
7zr a -mx9 -mmt4 -r -sse -w. -y -t7z archive/%PROJECT%-%VERSION%.7z %PROJECT%-%VERSION%
move %PROJECT%-%VERSION% release
