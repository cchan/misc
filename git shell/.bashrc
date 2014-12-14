# Sets up a convenient git Bash environment. Copy into ~. (that is, C:/Users/You/)

cd ~/Desktop/github

alias gps="git push origin"
alias gpl="git pull origin"
alias gs="git status"
alias gc="git add -A && git commit"
alias cd..="cd .."
alias dir="ls"
alias cls="clear"
alias tbb="cd ~/Desktop/github/2015-4029 && git status"
alias rd="cd ~/Desktop/github/r-d && git status"
alias lhsmath="cd ~/Desktop/github/lhsmath && git status"
alias hackne="cd ~/Desktop/github/hackne && git status"
alias scifair="cd ~/Desktop/github/scifair/scifair2015 && git status"
alias lib="cd ~/Desktop/github/lib && git status"

clear
echo HELLO!
echo Try using commands "tbb" or "rd". "notepad ~/.bashrc" for details on these aliases.

eval `ssh-agent`
ssh-add