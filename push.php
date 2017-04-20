#!/usr/bin/env php
<?php

require_once('./websockets.php');
require_once('./php/connect.php');
$sql = "select secret from game";
if (!$result = $db->query($sql)) {
	echo "Query: " . $sql . "\n";
	echo "Errno: " . $db->errno . "\n";
	echo "Error: " . $db->error . "\n";
	exit;
}
$row = $result->fetch_row();
$secret = $row[0];

class echoServer extends WebSocketServer {

	protected function process ($user, $message) {
		global $secret;
		$usersecret = substr($message, 0, 24);
		$message = substr($message, 24, strlen($message) - 24);
		$sarray = array_slice($this->sockets, 1);
		if($secret === $usersecret){
			foreach($sarray as $bsocket){
				$buser = $this->getUserBySocket($bsocket);
				if($buser->id === $user->id)
					continue;
				$this->send($buser, $message);
			}
		}
	}

	protected function connected ($user) {
	}

	protected function closed ($user) {
	}
}

$echo = new echoServer("0.0.0.0","2017");

try {
	$echo->run();
}
catch (Exception $e) {
	$echo->stdout($e->getMessage());
}
