for pcapdir in `php php/getpcapdir.php`
do
	mkdir /var/www/html/pcap/$pcapdir
done
