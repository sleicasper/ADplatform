function L_deluser()
{
	username=$1;
	umount /home/$username
	rm /opt/$username.img
	userdel $username -r
}
function deluserservice()
{
	user=$1
	for  ser in   "$@"
	do
		if [ "$user" == "$ser" ]
		then
			echo
		else
			sername=$user\_$ser
			L_deluser $sername
			rm /etc/xinetd.d/$sername
		fi
	done
}
function delallplayer()
{
	for user in `php php/getplayer.php`
	do
		L_deluser $user
	done
}
function delallservice()
{
	service=$1
	for user in `php php/getplayer.php`
	do
		deluserservice $user $service
	done
}
function killser()
{
	ser=$1
	ps axf | grep $ser | grep -v grep >> /dev/zero
	if [ $? == 0 ]
	then
		kill -9 `ps axf | grep $ser | grep -v grep | awk '{print $1}'`
	fi
}


cat /etc/security/limits.conf | grep \# > /etc/security/limits.conf
grep -v \# service.txt > /tmp/.32jfisoijb.txt
while read LINE
do
	delallservice $LINE
done < /tmp/.32jfisoijb.txt
rm /tmp/.32jfisoijb.txt

delallplayer
service xinetd restart
php dbsetup/clean.php
rm -r /var/www/html/pcap/*
killser push.php
killser capturepackage
killser updateflag
killser updateround
killser updatescore
killser tcpdump
killser sleep
