function dbg()
{
	apt install gcc g++ git libssl-dev
	pip install --upgrade pip
	pip install pwntools
}
function setup_envir()
{
	apt install expect
	apt install xinetd gcc-multilib
	pip install websocket-client
}
dbg
setup_envir
#reboot
