@echo off

::Event Viewer and Task Scheduler are amazing

::chk git statuses, make sure to do all that uname-pwd stuff
::chk stuff

echo ----------------GIT REPOS----------------
echo.
pushd .
for /F "usebackq tokens=*" %%A in (`dir /ad /b /s ^| findstr ".git$"`) do (
	cd %%A/..
	echo ----------------Repo----------------
	cd
	echo ------------------------------------
	
	git status
	
	for /F "usebackq tokens=*" %%B in (`git remote`) do (
		echo REMOTE %%B:
		git fetch %%B
		git diff --stat master origin/master
			::if CRLF warning, ensure all changes are committed,
			:: delete the offending file,
			:: and then git reset --hard HEAD
	)
	
	echo.
	echo.
)
popd

echo Done.
