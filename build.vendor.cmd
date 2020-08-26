@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

if not exist vendor\ mkdir vendor

set VENDOR_VERSION=1.0.0
if not exist vendor\xui-%VENDOR_VERSION%.7z curl --insecure --location https://github.com/g-stefan/xui/releases/download/v%VENDOR_VERSION%/xui-%VENDOR_VERSION%.7z --output vendor\xui-%VENDOR_VERSION%.7z
