@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

set PROJECT=xyo-cloud
set VERSION_LAST=1.3.0

set VENDOR_XUI_VERSION=2.0.0

set VERSION=0.0.0
setlocal enabledelayedexpansion
for /F "tokens=* USEBACKQ" %%F in (`xyo-version --no-bump --get "--version-file=%PROJECT%.version.ini" %PROJECT%`) do (
	set VERSION=%%F
)
for /F "delims=" %%i in ('echo %VERSION%') do endlocal && set VERSION=%%i
