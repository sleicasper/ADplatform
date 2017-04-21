function basic()
{
	apt update
	apt upgrade
	apt install vim expect
	echo "
	set mouse=a
	set nu
	if has(\"autocmd\")
	  au BufReadPost * if line(\"'\\\"\") > 1 && line(\"'\\\"\") <= line(\"$\") | exe \"normal! g'\\\"\" | endif
	endif" >> /etc/vim/vimrc

	if [ ! -f "/root/.ssh/id_rsa" ]; then
		expect -c "
		spawn ssh-keygen
			expect {
			\"*y/n*\" {send \"y\r\"; exp_continue}
			\"*key*\" {send \"\r\"; exp_continue}
			\"*passphrase*\" {send \"\r\"; exp_continue}
			\"*again*\" {send \"\r\";}
			}
		"
	fi
	mkdir /root/.ssh
	touch /root/.ssh/authorized_keys
	echo "ClientAliveInterval 60" >> /etc/ssh/sshd_config
	echo "ClientAliveCountMax 6" >> /etc/ssh/sshd_config

function lamp()
{
	apt install apache2
	apt install php
	apt-get install libapache2-mod-php
	apt install mysql-server php7.0-mysql
	apt-get install mysql-client
	service apache2 restart
	mkdir /var/www/html/pcap
	echo hello > /var/www/html/pcap/index.html
}
function dbg()
{
	apt install gcc gdb
	pip install pwntool
}
basic
lamp
