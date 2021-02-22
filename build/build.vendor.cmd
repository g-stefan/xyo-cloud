@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\build\build.config.cmd

if not exist vendor\ mkdir vendor

if not exist vendor\xui-%VENDOR_XUI_VERSION%.7z curl --insecure --location https://github.com/g-stefan/xui/releases/download/v%VENDOR_XUI_VERSION%/xui-%VENDOR_XUI_VERSION%.7z --output vendor\xui-%VENDOR_XUI_VERSION%.7z
