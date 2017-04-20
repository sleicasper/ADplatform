#!/usr/bin/python2.7
from pwn import *
from sys import argv
p = remote('127.0.0.1', int(argv[1]))
def add(note):
	p.recvuntil("4. exit\n")
	p.sendline('1')
	p.recvuntil("input note")
	p.sendline(note)
def delete(idx):
	p.recvuntil("4. exit\n")
	p.sendline('2')
	p.recvuntil("input id you want to delete")
	p.sendline(str(idx))
	return p.recvuntil("1. new note")
def edit(idx, note):
	p.recvuntil("4. exit\n")
	p.sendline('3')
	p.recvuntil("input id you want to edit")
	p.sendline(str(idx))
	p.sendline(note)
	return p.recvuntil("1. new note")
for i in range(10):
	add("hello")
rd = delete(0)
rd = delete(0)
if 'There isn\'t a note yet' not in rd:
	exit(1)
rd = edit(3, 'aaaaaaa')
