@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\project\build.config.cmd
call .\project\build.clean.cmd
call .\project\build.vendor.cmd
call .\project\build.version.cmd
call .\project\build.make.cmd
call .\project\build.archive.cmd
call .\project\build.update.cmd
call .\project\build.clean.cmd
