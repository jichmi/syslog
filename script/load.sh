#!/bin/bash
start=`date +%s%N`
cauth=`curl -s http://syslog.hust.edu.jcm/index.php?r=load/auth`" auth entries have been loaded"
cmessage=`curl -s  http://syslog.hust.edu.jcm/index.php?r=load/message`" message entries have been loaded"
clogin=`curl -s  http://syslog.hust.edu.jcm/index.php?r=load/login`" login entries have been loaded"
echo $clogin
echo $cauth
echo $cmessage
end=`date +%s%N`
dif=$[ end - start ]
echo "spend time:"$[$dif/1000000]" ms"
#echo 'load success'
