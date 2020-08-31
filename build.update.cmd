@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call build.config.cmd

set VERSION_LATEST=X.X.X
SETLOCAL ENABLEDELAYEDEXPANSION
FOR /F "tokens=* USEBACKQ" %%F IN (`xyo-version --no-bump --get "--version-file=%PROJECT%.version.ini" %PROJECT%`) DO (
	SET VERSION_LATEST=%%F
)

if "%VERSION_LATEST%" == "%VERSION_LAST%" goto :eof

if exist build\ rmdir /Q /S build
if not exist build\ mkdir build

if exist archive\%PROJECT%-update-%VERSION_LAST%-to-%VERSION_LATEST%.7z del /Q /F archive\%PROJECT%-update-%VERSION_LAST%-to-%VERSION_LATEST%.7z

pushd build
7zr x ../archive/%PROJECT%-%VERSION_LAST%.7z
7zr x ../archive/%PROJECT%-%VERSION_LATEST%.7z
php ../util/update.php %PROJECT% %VERSION_LAST% %VERSION_LATEST%
7zr a -mx9 -mmt4 -r- -sse -w. -y -t7z ../archive/%PROJECT%-update-%VERSION_LAST%-to-%VERSION_LATEST%.7z %PROJECT%-update-%VERSION_LAST%-to-%VERSION_LATEST%
popd

rmdir /Q /S build
