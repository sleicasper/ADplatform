mkdir ~/kcp
scp server_linux_amd64 ~/kcp/
echo "./server_linux_amd64 -l :1091 -t `hostname -I|awk '{print $1}'`:1090 -key guboom -mtu 1400 -sndwnd 2048 -rcvwnd 2048 -mode normal >/dev/zero 2>&1 &" > ~/kcp/start.sh
chmod u+x ~/kcp/start.sh
~/kcp/start.sh
