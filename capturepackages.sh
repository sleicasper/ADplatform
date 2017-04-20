#!/bin/bash
roundtime=300
i=0
while true
do
	echo $i
	php php/selectusernaeme.php |sed -e '/^$/d' | while read line
	do
		user=`echo $line | awk '{print $1}'`
		dirname=`echo $line | awk '{print $2}'`
		i=0
		for port in `php php/selectplayerport.php $user`
		do
			if [ $i == 0 ]
			then
				portargv=$port
			else
				portargv=$portargv' or '$port
			fi
			i=$[ $i + 1 ]
		done
		mkdir /var/www/html/pcap/$dirname
		cmd='timeout '$roundtime' tcpdump -i lo port '$portargv' -w /var/www/html/pcap/'$dirname'/'`date +%Y%m%d%H%M`'.pcap'
		echo $cmd
		nohup $cmd 2>&1 > /dev/zero &

	done
	i=$[ $i + 1 ]
	sleep $roundtime
done
