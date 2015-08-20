
echo Fetching.
curl $2 -D h_$1_1.txt > /dev/null
echo Wait a few seconds and then press enter.
read
echo Fetching.
curl $2 -D h_$1_2.txt > /dev/null
echo Done. Diffing.
diff h_$1_1.txt h_$1_2.txt
echo Done.