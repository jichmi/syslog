#!/bin/bash
cd /var/www/syslog/script/
./login
php ./auth.php
php ./message.php
cp ./login.xml /var/www/syslog/data/ 
cp ./auths.xml /var/www/syslog/data/ 
cp ./messages.xml /var/www/syslog/data/ 
file_login=./backup/login_`date +%s`
file_auth=./backup/auth_`date +%s`
file_message=./backup/message_`date +%s`
cp ./login.xml "$file_login"
cp ./auths.xml "$file_auth"
cp ./messages.xml "$file_message"
