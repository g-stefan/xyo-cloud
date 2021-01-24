@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\project\build.config.cmd

if exist build\ rmdir /Q /S build

7zr x vendor/xui-%VENDOR_XUI_VERSION%.7z
xcopy /E /H /K /Y xui-%VENDOR_XUI_VERSION%\vendor build\site\lib\
mkdir build\site\lib\xui
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui.complete.min.css build\site\lib\xui\xui.complete.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\js\xui.complete.min.js build\site\lib\xui\xui.complete.min.js
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-animated-dna.min.css build\site\lib\xui\xui-animated-dna.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-2.min.css build\site\lib\xui\xui-dashboard-theme-2.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-3.min.css build\site\lib\xui\xui-dashboard-theme-3.min.css
copy /y xui-%VENDOR_XUI_VERSION%\xui-version-lib.txt build\site\xui-version-lib.txt
rmdir /Q /S xui-%VENDOR_XUI_VERSION%

xcopy /E /H /K /Y source build
xyo-version --no-bump --version-file=xyo-cloud.version.ini --file-in=build/site/config/xyo-cloud.80.php --file-out=build/site/config/xyo-cloud.80.php.version xyo-cloud
move /Y build\site\config\xyo-cloud.80.php.version build\site\config\xyo-cloud.80.php
