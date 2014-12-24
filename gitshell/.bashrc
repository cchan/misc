# Sets up a convenient git Bash environment. Copy into ~. (that is, C:/Users/You/)
# Stuff nearer the top is more customizable.

# Gets to the right place
cd ~/Desktop/github

# Welcome!
clear
echo HELLO!
echo Try using commands \"gs\" or \"gc\" or \"gsa\". Try \"notepad ~/.bashrc\" to look at all your aliases.


# Makes me sign in with SSH key if necessary
# ("ssh-agent" returns a bash script that sets global variables)
# If something messes up, just remove the starter file and restart the shell with ssh-reset.
# Otherwise it'll handle itself.
sshtmp="/tmp/sshagentthing.sh"
ssh-start () { ssh-agent > $sshtmp; . $sshtmp; ssh-add; }
ssh-reset () { echo "Resetting SSH agent" ;rm $sshtmp; kill $SSH_AGENT_PID; ssh-start; }
if [ ! -f $sshtmp ]; then # Only do it if daemon doesn't already exist
	echo.
	echo "New SSH agent"
	ssh-start
else # Otherwise, everything is preserved until the ssh-agent process is stopped.
	echo "Reauthenticating"
	. $sshtmp
fi


# Aliases for various repos
alias tbb="cd ~/Desktop/github/2015-4029 && git status"
alias rd="cd ~/Desktop/github/r-d && git status"
alias lhsmath="cd ~/Desktop/github/lhsmath && git status"
alias hackne="cd ~/Desktop/github/hackne && git status"
alias scifair="cd ~/Desktop/github/scifair && git status"
alias lib="cd ~/Desktop/github/lib && git status"

# Editor aliases
alias npp="\"C:\Program Files (x86)\Notepad++\notepad++.exe\""
alias robotc="\"C:\Program Files (x86)\Robomatter Inc\ROBOTC Development Environment 4.X\RobotC.exe\""
alias sublime="\"C:\Program Files\Sublime Text 3\sublime_text.exe\""

# Git shortforms.
alias gs="git status"
alias gc="git add -A && git commit"
gu () { gc "$@"; git push;} # commits things and pushes them, with all arguments to it passed to git commit.

# The amazing git-status-all script, which reports on the status of every repo in the current folder.
gsa () {
	find -type d -name .git -prune -exec bash -c '
	cd "{}/..";
	echo "
--------{}--------";
	git remote update >/dev/null &>/dev/null
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
				git log -1 --pretty=format:"LATEST: %ar	%<(50,trunc)%s" $LOCAL --
			elif [ $LOCAL = $BASE ]; then
				echo -e "\E[31mNeed to pull!\E[0m"
				git log -1 --pretty=format:"LOCAL: %ar	%<(50,trunc)%s" $LOCAL --
				git log -1 --pretty=format:"REMOTE: %ar	%<(50,trunc)%s" $REMOTE --
			elif [ $REMOTE = $BASE ]; then
				echo -e "\E[31mNeed to push!\E[0m"
				git log -1 --pretty=format:"LOCAL: %ar	%<(50,trunc)%s" $LOCAL --
				git log -1 --pretty=format:"REMOTE: %ar	%<(50,trunc)%s" $REMOTE --
			else
				echo -e "\E[31mDiverged!!\E[0m"
				git log -1 --pretty=format:"LOCAL: %ar	%<(50,trunc)%s" $LOCAL --
				git log -1 --pretty=format:"REMOTE: %ar	%<(50,trunc)%s" $REMOTE --
				git log -1 --pretty=format:"MERGE-BASE: %ar	%<(50,trunc)%s" $BASE --
			fi
		else
			echo "No upstream configured."
			git log -1 --pretty=format:"LATEST: %ar	%<(50,trunc)%s" $SHORT --
		fi
	done
	' \;
}
