#!/usr/bin/python2.7
from pwn import *
from sys import argv
p = remote('127.0.0.1', int(argv[1]))
d = p.recv()
if 'Let\'s start the CTF:' in d:
	exit(0)
else:
	exit(1)
