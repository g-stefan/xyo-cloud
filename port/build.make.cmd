@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\port\build.config.cmd

if exist bin\ rmdir /Q /S bin

7zr x vendor/xui-%VENDOR_XUI_VERSION%.7z
xcopy /E /H /K /Y xui-%VENDOR_XUI_VERSION%\vendor bin\site\lib\
mkdir bin\site\lib\xui
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui.complete.min.css bin\site\lib\xui\xui.complete.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\js\xui.complete.min.js bin\site\lib\xui\xui.complete.min.js
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-animated-dna.min.css bin\site\lib\xui\xui-animated-dna.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-2.min.css bin\site\lib\xui\xui-dashboard-theme-2.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-3.min.css bin\site\lib\xui\xui-dashboard-theme-3.min.css
copy /y xui-%VENDOR_XUI_VERSION%\xui-version-lib.txt bin\site\xui-version-lib.txt
rmdir /Q /S xui-%VENDOR_XUI_VERSION%

xcopy /E /H /K /Y source bin
xyo-version --no-bump --version-file=xyo-cloud.version.ini --file-in=bin/site/config/xyo-cloud.80.php --file-out=bin/site/config/xyo-cloud.80.php.version xyo-cloud
move /Y bin\site\config\xyo-cloud.80.php.version bin\site\config\xyo-cloud.80.php
