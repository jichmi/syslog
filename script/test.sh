#!/bin/bash
start=`date +%s%N`
cd /var/www/syslog/script/>/dev/null
#file_login=./backup/login_`date +%s`
#file_auth=./backup/auth_`date +%s`
#file_message=./backup/message_`date +%s`
#mv ./login.xml "$file_login"
#mv ./auths.xml "$file_auth"
#mv ./messages.xml "$file_message"
#./loginfo
#php ./auth.php>/dev/null
php ./message.php
#cp ./login.xml /var/www/syslog/data/ 
#cp ./auths.xml /var/www/syslog/data/ 
#cp ./messages.xml /var/www/syslog/data/ 
end=`date +%s%N`
dif=$[ end - start ]
echo "spend time:"$[$dif]" ms"
