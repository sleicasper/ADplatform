#!/usr/bin/python2.7
from pwn import *
from sys import argv
p = remote('127.0.0.1', int(argv[1]))
p.recvuntil('Your choice :')
p.sendline('1')
p.recvuntil('Give me your description of bullet :')
p.sendline('\x0032')
rd = p.recvuntil('Silver Bullet')
if 'Your power is : 0' not in rd:
	exit(1)

p.recvuntil('Your choice :')
p.sendline('1')
p.recvuntil('Give me your description of bullet :')
p.sendline('032')
rd = p.recvuntil('Silver Bullet')
if 'Your power is : 3' not in rd:
	exit(1)

p.recvuntil('Your choice :')
p.sendline('3')
rd = p.recvuntil('Silver Bullet')
if '+ HP : 2147483647' not in rd:
	exit(1)


p.recvuntil('Your choice :')
p.sendline('2')
p.recvuntil('Give me your another description of bullet :')
p.sendline('aaa')
rd = p.recvuntil('Silver Bullet')
if "Your new power is : 6" not in rd:
	exit(1)


