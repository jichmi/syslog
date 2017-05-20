#!/bin/bash
start=`date +%s%N`
cd /var/www/syslog/script/>/dev/null
./login>/dev/null
php ./auth.php>/dev/null
php ./message.php>/dev/null
cp ./login.xml /var/www/syslog/data/ 
cp ./auths.xml /var/www/syslog/data/ 
cp ./messages.xml /var/www/syslog/data/ 
file_login=./backup/login_`date +%s`
file_auth=./backup/auth_`date +%s`
file_message=./backup/message_`date +%s`
cp ./login.xml "$file_login"
cp ./auths.xml "$file_auth"
cp ./messages.xml "$file_message"
end=`date +%s%N`
dif=$[ end - start ]
echo "spend time:"$[$dif/1000000]" ms"
