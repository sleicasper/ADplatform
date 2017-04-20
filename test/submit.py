#!/usr/bin/python
from requests import *
import sys, subprocess
def submitflag(flag, PHPSESSID):
	url = "http://139.162.126.185/submit.php"
	data = {"flag": flag}
	cookies = {'PHPSESSID': PHPSESSID}
	r = post(url, data = data, cookies = cookies)
	if 'Correct' in r.content:
		print 'success'
	else:
		print 'fail'
flags = (subprocess.check_output("php getflag.php", shell=True)).split('\n')

for flag in flags:
	if flag != '':
		submitflag(flag, 'v4da0pljqpbjd1vjt2i9t5i892')
