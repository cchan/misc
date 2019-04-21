while true
do
  nc www.anonvote.com 80 < req.txt > /dev/null
  echo -n "."
done
