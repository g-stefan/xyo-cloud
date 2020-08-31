@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call build.config.cmd

if exist release\ rmdir /Q /S release

7zr x vendor/xui-%VENDOR_XUI_VERSION%.7z
xcopy /E /H /K /Y xui-%VENDOR_XUI_VERSION%\vendor release\site\lib\
mkdir release\site\lib\xui
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui.complete.min.css release\site\lib\xui\xui.complete.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\js\xui.complete.min.js release\site\lib\xui\xui.complete.min.js
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-animated-dna.min.css release\site\lib\xui\xui-animated-dna.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-2.min.css release\site\lib\xui\xui-dashboard-theme-2.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-3.min.css release\site\lib\xui\xui-dashboard-theme-3.min.css
copy /y xui-%VENDOR_XUI_VERSION%\xui-version-lib.txt release\site\xui-version-lib.txt
rmdir /Q /S xui-%VENDOR_XUI_VERSION%

xcopy /E /H /K /Y source release
xyo-version --no-bump --version-file=xyo-cloud.version.ini --file-in=release/site/config/xyo-cloud.80.php --file-out=release/site/config/xyo-cloud.80.php.version xyo-cloud
move /Y release\site\config\xyo-cloud.80.php.version release\site\config\xyo-cloud.80.php
