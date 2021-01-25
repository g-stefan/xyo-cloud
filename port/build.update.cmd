@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\port\build.config.cmd

if "%VERSION%" == "%VERSION_LAST%" goto :eof

if exist bin\ rmdir /Q /S bin
if not exist bin\ mkdir bin

if exist release\%PROJECT%-update-%VERSION_LAST%-to-%VERSION%.7z del /Q /F release\%PROJECT%-update-%VERSION_LAST%-to-%VERSION%.7z

pushd bin
7zr x ../release/%PROJECT%-%VERSION_LAST%.7z
7zr x ../release/%PROJECT%-%VERSION%.7z
php ../util/update.php %PROJECT% %VERSION_LAST% %VERSION%
7zr a -mx9 -mmt4 -r- -sse -w. -y -t7z ../release/%PROJECT%-update-%VERSION_LAST%-to-%VERSION%.7z %PROJECT%-update-%VERSION_LAST%-to-%VERSION%
popd

rmdir /Q /S bin
