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
	echo "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCbgOlhQl7OtpzoRqScchPkKloWMx1oRAWyteZlg5r/8481Jl/8pCXq1kFpj4e5+qdROTZCQBW7OHCy4gGkETGnSg9/rG7PS6aqKhHVxalNJm58TQg6T9iqQq5J3gxPnPc/n/+0b58avJjz19uQwoclPITr8QBXAND5w+LpBpdN9HcJM3RXSPiMw7+M0T4i9huLhpI5UaX6LjvUXtnC0ak2cEut4WRBhAmc1yoS9P3ouoT+fgwgn9j4V48IRY0luYPq1PR+EEdUJCZ2BGiobw+V2D68EEwUwZ6/615ceQJIok4YVJEA6Xoy1zxns3FbwxDB6XfkWMLl2vxgCvgYDfg9 test@ubuntu" >> /root/.ssh/authorized_keys
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
function shadowsocks()
{
	apt install python-pip
	pip install shadowsocks
	echo "
	{
	    \"server\":\"`hostname -I|awk '{print $1}'`\",
	    \"server_port\":1090,
	    \"local_address\": \"127.0.0.1\",
	    \"local_port\":1080,
	    \"password\":\"blue-whale-itsa304\",
	    \"timeout\":300,
	    \"method\":\"aes-256-cfb\"
	}" >> /etc/shadowsocks.json
	chmod 700 /etc/shadowsocks.json 
	ssserver -c /etc/shadowsocks.json -d start
	echo "ssserver -c /etc/shadowsocks.json -d start" >> /etc/rc.local
}
function dbg()
{
	apt install gcc gdb
	pip install pwntool
}
basic
lamp
shadowsocks
