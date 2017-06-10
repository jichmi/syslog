#!/bin/bash
start=`date +%s%N`
cd /var/www/syslog/script/>/dev/null
file_login=./backup/login_`date +%s`
file_auth=./backup/auth_`date +%s`
file_message=./backup/message_`date +%s`
clogin=`./login`" login has been translated"
cauth=`php ./auth.php`" auth has been translated"
cmessage=`php ./message.php`" message has deen translated"
echo $clogin
echo $cauth
echo $cmessage
#sleep 2
cp ./login.xml /var/www/syslog/data/ 
cp ./auths.xml /var/www/syslog/data/ 
cp ./messages.xml /var/www/syslog/data/ 
cp ./login.xml "$file_login"
cp ./auths.xml "$file_auth"
cp ./messages.xml "$file_message"
end=`date +%s%N`
dif=$[ end - start ]
echo "spend time:"$[$dif/1000000]" ms"
