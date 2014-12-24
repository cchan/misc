#
# Notes:
# if it's not "Up-to-date and nothing to commit.", that means you're either not up to date or you haven't --set-upstream-to= yet.
# if it says "fatal: no remote repository specified" it means that you don't have a remote set up or haven't set it to upstream yet.
#

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
