#!/bin/bash
start=`date +%s%N`
cmessage=`curl -s http://syslog.hust.edu.jcm/index.php?r=maintenance/index`" message entries have been deleted"
echo $cmessage
end=`date +%s%N`
dif=$[ end - start ]
echo "spend time:"$[$dif/1000000]" ms"

