find -type d -name .git -prune -exec bash -c '
cd "{}/..";
echo "

--------{}--------";
git fetch;
git branch -a -vv;
stat=$(git status);
if grep -lq "nothing to commit, working directory clean" <<<"$stat" >nul && grep -lq "Your branch is up-to-date with " <<<"$stat" >nul;
then echo "Up-to-date and nothing to commit.";
else echo "$stat";
fi' \;

#
# Notes:
# if it's not "Up-to-date and nothing to commit.", that means you're either not up to date or you haven't --set-upstream-to= yet.
# if it says "fatal: no remote repository specified" it means that you don't have a remote set up or haven't set it to upstream yet.
#

