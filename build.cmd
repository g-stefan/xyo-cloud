@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

set ACTION=%1
if "%1" == "" set ACTION=release
echo -^> %ACTION% xyo-cloud

call build.%ACTION%.cmd
