@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\build\build.config.cmd

set ACTION=%1
if "%1" == "" set ACTION=make
if not exist ".\build\build.%ACTION%.cmd" goto Info
echo -^> %ACTION% %PROJECT%
call .\build\build.%ACTION%.cmd
goto :eof
:Info
echo build [mode]
