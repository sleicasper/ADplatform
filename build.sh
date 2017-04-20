function create_img()
{
	imgname=$1.img
	L_size=$2
	dd if=/dev/zero of=/opt/$imgname bs=1M count=$L_size
	mkfs.ext4 /opt/$imgname
}

function L_adduser()
{
	username=$1;
	password=$2;
	useradd -m $username -s /bin/bash
	echo $username:$password | chpasswd
	create_img $username 50
	mount -o loop,rw /opt/$username.img /home/$username
	rm -r /home/$username/lost+found
	chmod 701 /home/$username
	chown $username /home/$username
	chgrp $username /home/$username
	echo "$username soft nproc 128" >> /etc/security/limits.conf
	echo "$username hard nproc 128" >> /etc/security/limits.conf
	echo "$username soft core 0" >> /etc/security/limits.conf
	echo "$username hard core 0" >> /etc/security/limits.conf
	echo "$username soft nofile 128" >> /etc/security/limits.conf
	echo "$username hard nofile 128" >> /etc/security/limits.conf
}

function addservice()	#
{
	player=$1
	service=$2
	port=$3
	newuser=$player\_$service
	mkdir /home/$player/$service
	cp bin/$service /home/$player/$service/
	chmod 701 /home/$player/$service/$service
	chown -R $player /home/$player/$service
	chgrp -R $player /home/$player/$service
	L_adduser $newuser `cat /dev/urandom |head -c 12| base64`
	echo "service ctf
	{
	    disable = no
	    socket_type = stream
	    protocol    = tcp
	    wait        = no
	    user        = $newuser
	    bind        = 0.0.0.0
	    server      = /home/$player/$service/$service
	    type        = UNLISTED
	    port        = $port
	}" > /etc/xinetd.d/$newuser
	php php/insertplayerchall.php $player $service $port
}
function AddAllUser()
{
	for user in `php php/getplayer.php`
	do
		playerpw=`cat /dev/urandom |head -c 12| base64`
		L_adduser $user $playerpw
		php php/updateplayerpw.php $user $playerpw
	done
}
function AddAllService()
{
	binname=$1
	portstart=$2
	
	php php/insertchall.php $binname
	
	i=0
	for user in `php php/getplayer.php`
	do
		addservice $user $binname $[$portstart+$i]
		i=$[$i+1]
	done
}

cp html/template.php /var/www/html/register.php
AddAllUser
grep -v \# service.txt > /tmp/.32jfisoijb.txt
while read LINE
do
	AddAllService $LINE
done < /tmp/.32jfisoijb.txt
rm /tmp/.32jfisoijb.txt
service xinetd restart
php php/insertscoreboard.php
php php/insertflag.php
php php/insertround.php
./createpcapdir.sh
