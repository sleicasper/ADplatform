from requests import *
url = "http://139.162.126.185/register.php"
def reg(name):
	data = {"username":name, "pass":"1234", "confirmpass":"1234"}
	r = post(url, data = data)
	if 'success' in r.content:
		print 'success'
reg('217')
reg('AAA')
reg('casper')
reg('PPP')
reg('0ops')
reg('dragonsector')
