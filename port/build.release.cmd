@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\port\build.config.cmd
call .\port\build.clean.cmd
call .\port\build.vendor.cmd
call .\port\build.version.cmd
call .\port\build.make.cmd
call .\port\build.archive.cmd
call .\port\build.update.cmd
call .\port\build.clean.cmd
