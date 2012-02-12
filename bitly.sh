if [ -z "$(pgrep bitly)" ]
    then
        echo "bitly is not running"
    else
        echo "bitly is running"
fi
