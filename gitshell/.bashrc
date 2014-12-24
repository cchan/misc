# Sets up a convenient git Bash environment. Copy into ~. (that is, C:/Users/You/)

cd ~/Desktop/github

alias gs="git status"
alias gc="git add -A && git commit"
gu () { gc "$@"; git push;}
alias cd..="cd .."
alias dir="ls"
alias cls="clear"
alias tbb="cd ~/Desktop/github/2015-4029 && git status"
alias rd="cd ~/Desktop/github/r-d && git status"
alias lhsmath="cd ~/Desktop/github/lhsmath && git status"
alias hackne="cd ~/Desktop/github/hackne && git status"
alias scifair="cd ~/Desktop/github/scifair && git status"
alias lib="cd ~/Desktop/github/lib && git status"
alias npp="\"C:\Program Files (x86)\Notepad++\notepad++.exe\""

gsa () {
	find -type d -name .git -prune -exec bash -c '
	cd "{}/..";
	echo "
--------{}--------";
	git remote update >/dev/null
	git -c color.status=always status -s

	for branch in $(git for-each-ref --sort="-authordate:iso8601" --format="%(refname)" refs/heads/); do
		SHORT=$(basename "$branch")
		
		echo -e -n "\E[1;33m$SHORT:\E[0m "
		if [[ -n $(git config --get branch.$SHORT.remote) ]]; then
			LOCAL=$(git rev-parse "$SHORT")
			REMOTE=$(git rev-parse "$SHORT"@{upstream})
			BASE=$(git merge-base "$SHORT" "$SHORT"@{upstream})
			
			if [ $LOCAL = $REMOTE ]; then
				echo -e "\E[32mUp-to-date.\E[0m"
			elif [ $LOCAL = $BASE ]; then
				echo -e "\E[31mNeed to pull!\E[0m"
			elif [ $REMOTE = $BASE ]; then
				echo -e "\E[31mNeed to push!\E[0m"
			else
				echo -e "\E[31mDiverged!!\E[0m"
			fi
		else
			echo "No upstream configured."
		fi
		git --no-pager log --pretty=format:"LOCAL: %ar	%<(50,trunc)%s" "$SHORT" -n 1
		echo.
	done
	' \;
}

clear
echo HELLO!
echo Try using commands "gs" or "gc". "notepad ~/.bashrc" for details on these aliases.

eval `ssh-agent`
ssh-add