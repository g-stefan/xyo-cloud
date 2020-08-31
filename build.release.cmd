@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call build.config.cmd
call build.clean.cmd
call build.vendor.cmd
call build.version.cmd
call build.make.cmd
call build.archive.cmd
call build.update.cmd
call build.clean.cmd
