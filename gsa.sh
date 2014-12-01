find -type d -name .git -prune -exec bash -c '
cd "{}/..";
echo "

--------{}--------";
git fetch;
git branch -a;
stat=$(git status);
if grep -lq "nothing to commit, working directory clean" <<<"$stat" >nul && grep -lq "Your branch is up-to-date with " <<<"$stat" >nul;
then echo "Up-to-date and nothing to commit.";
else echo "$stat";
fi' \;
