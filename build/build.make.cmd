@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\build\build.config.cmd
call .\build\build.vendor.cmd

if exist output\ rmdir /Q /S output

7zr x vendor/xui-%VENDOR_XUI_VERSION%.7z
xcopy /E /H /K /Y xui-%VENDOR_XUI_VERSION%\vendor output\site\lib\
mkdir output\site\lib\xui
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui.complete.min.css output\site\lib\xui\xui.complete.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\js\xui.complete.min.js output\site\lib\xui\xui.complete.min.js
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-animated-dna.min.css output\site\lib\xui\xui-animated-dna.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-2.min.css output\site\lib\xui\xui-dashboard-theme-2.min.css
copy /Y xui-%VENDOR_XUI_VERSION%\css\xui-dashboard-theme-3.min.css output\site\lib\xui\xui-dashboard-theme-3.min.css
copy /y xui-%VENDOR_XUI_VERSION%\xui-version-lib.txt output\site\xui-version-lib.txt
rmdir /Q /S xui-%VENDOR_XUI_VERSION%

xcopy /E /H /K /Y source output
xyo-version --no-bump --version-file=version.ini --file-in=output/site/config/xyo-cloud.80.php --file-out=output/site/config/xyo-cloud.80.php.version xyo-cloud
move /Y output\site\config\xyo-cloud.80.php.version output\site\config\xyo-cloud.80.php
