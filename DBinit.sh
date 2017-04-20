function create_img()
{
	imgname=$1.img
	L_size=$2
	dd if=/dev/zero of=/opt/$imgname bs=1M count=$L_size
	mkfs.ext4 /opt/$imgname
}
function setup_ADdisk()
{
	chmod 700 /opt
	chmod 700 /tmp
	create_img tmp 500
	mount -o loop,rw /opt/tmp.img /tmp/
	mount -t proc -o remount,defaults,hidepid=2 /proc
}
setup_ADdisk
php dbsetup/build.php
./move.sh
echo hello > /var/www/html/pcap/index.html
