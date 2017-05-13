#!/bin/bash
last -i|grep -v 'reboot'|awk '{print $1,$2,$3,$5,$6,$7,$9,$10}' OFS='|'>last.out
last -i|grep  'reboot'|awk '{print $1,$2,$4,$6,$7,$10}' OFS='|'>reboot.out
lastb -i|awk '{print $1,$2,$3,$5,$6,$7}' OFS='|'>lastb.out
cp "./last.out" "/var/www/syslog/data/" 
cp "./reboot.out" "/var/www/syslog/data/" 
cp "./lastb.out" "/var/www/syslog/data/" 
file_last=./last_`date +%s`
file_lastb=./lastb_`date +%s`
file_reboot=./reboot_`date +%s`
cp "./last.out" "$file_last"
cp "./lastb.out" "$file_lastb"
cp "./reboot.out" "$file_reboot"
