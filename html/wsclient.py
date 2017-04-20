#!/usr/bin/python
from websocket import create_connection
import sys
msg = sys.argv[1]
ws = create_connection("ws://127.0.0.1:2017")
ws.send(msg)
ws.close()
