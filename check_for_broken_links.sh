#!/bin/bash


#file is assumed to end with ","

if [[ -z $1 ]]; then
    echo "parameter one should be file name"
    exit 0
fi
echo "read file " $1
if [[ ! -f $1 ]]; then
    echo "could not find file $1"
    exit 0
fi

HELP="$(cat $1)"
LENGTH=${#HELP}
INDEX=0;
while [  $LENGTH -gt 0 ]; do
    INDEXOFCOLON="$(awk -v a="$HELP" 'BEGIN{print index(a,",")}')"
    WORD="$(awk -v a="$HELP" -v b="$INDEXOFCOLON" 'BEGIN{print substr(a,1,b-1)}')"
    NUMBEROFCHARS=$((LENGTH - INDEXOFCOLON))
    HELP="$(awk -v a="$HELP" -v b="$INDEXOFCOLON" -v c="$NUMBEROFCHARS" 'BEGIN{print substr(a,b+1,c)}')"
    LENGTH=${#HELP}
    LIST[$INDEX]=$WORD
    INDEX=$((INDEX + 1))
done

ELEMENTS=${#LIST[@]}

for (( i=0;i<$ELEMENTS;i++)); do
    RESULT="$(wget -nv --spider --tries=3 --timeout=60 ${LIST[${i}]} 2>&1)"
    if [[ $RESULT != *"200 OK"* || $RESULT == *error_alice* ]] 
    then
        echo $RESULT
        echo "------------------${LIST[${i}]} seems corrupt"
    fi
done 
