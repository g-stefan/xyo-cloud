@echo off
rem Public domain
rem http://unlicense.org/
rem Created by Grigore Stefan <g_stefan@yahoo.com>

call .\build\build.config.cmd

SETLOCAL ENABLEDELAYEDEXPANSION

echo -^> github-release %PROJECT%

if not exist release\%PROJECT%-%VERSION%.7z echo Error - no release & exit 1
if not exist release\%PROJECT%-update-%VERSION_LAST%-to-%VERSION%.7z echo Error - no release update & exit 1

echo -^> github release %PROJECT% v%VERSION%

git pull --tags origin main
git fetch origin --tags --force
git fetch --prune origin "+refs/tags/*:refs/tags/*"
git rev-parse --quiet "v%VERSION%" 1>NUL 2>NUL
if not errorlevel 1 goto tagExists
git tag -a v%VERSION% -m "v%VERSION%"
git push --tags
echo Create release %PROJECT% v%VERSION%
github-release release --repo %PROJECT% --tag v%VERSION% --name "v%VERSION%" --description "Release"
pushd release
for /r %%i in (%PROJECT%-%VERSION%.7z) do echo Upload %%~nxi & github-release upload --repo %PROJECT% --tag v%VERSION% --name "%%~nxi" --file "%%i"
for /r %%i in (%PROJECT%-update-%VERSION_LAST%-to-%VERSION%.7z) do echo Upload %%~nxi & github-release upload --repo %PROJECT% --tag v%VERSION% --name "%%~nxi" --file "%%i"
popd

goto :eof

:tagExists
echo Release already exists
exit 0
