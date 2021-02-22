@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\build\build.config.cmd
call .\build\build.clean.cmd
call .\build\build.vendor.cmd
call .\build\build.version.cmd
call .\build\build.make.cmd
call .\build\build.archive.cmd
call .\build\build.update.cmd
call .\build\build.clean.cmd
