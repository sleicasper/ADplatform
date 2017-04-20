<?php
//change password 
require("connect.php");
function execsql($db, $sql){
	if (!$result = $db->query($sql)) {
	    echo "Query: " . $sql . "\n";
	    echo "Errno: " . $db->errno . "\n";
	    echo "Error: " . $db->error . "\n";
	    exit;
	}
	return $result;
}
function inittable($db){
	$password = sha1(random_bytes(12));
	$connectphp = <<<connectphp
	<?php
	\$db = new mysqli('127.0.0.1', 'monitor', '%s');
	if (\$db->connect_errno) {
		echo "Errno: " . \$db->connect_errno . "\\n";
		echo "Error: " . \$db->connect_error . "\\n";
		exit;
	}
	\$sql = "use monitor";
	if (!\$result = \$db->query(\$sql)) {
		echo "Query: " . \$sql . "\\n";
		echo "Errno: " . \$db->errno . "\\n";
		echo "Error: " . \$db->error . "\\n";
		exit;
	}
	?>
connectphp;
	$newconnectphp = sprintf($connectphp, $password);
	file_put_contents("html/connect.php", $newconnectphp);
	$sql = "create user 'monitor'@'localhost' IDENTIFIED BY '".$password."'";
	execsql($db, $sql);
	$sql = "create database monitor";
	execsql($db, $sql);
	$sql = "use monitor";
	execsql($db, $sql);
	$sql = "create table player(username char(20), password char(40), salt char(12), playername char(40),playerpassword char(16), pcapdirname char(40), primary key(username))";	
	execsql($db, $sql);
	$sql = "create table chall(challname char(20), primary key(challname))";
	execsql($db, $sql);
	$sql = "create table playerchall(playername char(20), challname char(20), port int, primary key(playername, challname))";
	execsql($db, $sql);
	$sql = "create table flag(challname char(20), username char(20), flag char(45), primary key(challname, username))";
	execsql($db, $sql);
	$sql = "create table scoreboard(challname char(20), username char(20), score decimal(6,1), primary key(challname, username))";
	execsql($db, $sql);
	$sql = "create table round(challname char(20), username char(20), status char(10), primary key(challname, username))";
	execsql($db, $sql);
	$sql = "create table roundhistory(defender char(20), challname char(20), attacker char(20), pwned int, down int, primary key(defender, challname, attacker, pwned, down))";
	execsql($db, $sql);
	$sql = "create table game(name char(20), round int, playernum int, challnum int, secret char(24), primary key(name))";
	execsql($db, $sql);
	$sql = "grant select, update, insert on monitor.* to monitor@localhost";
	execsql($db, $sql);
	$secret = base64_encode(random_bytes(18));
	$sql = "insert into game values('game0', 0, 2, 2, '" . $secret . "')";
	execsql($db, $sql);
}

function test($db){
}

inittable($db);
test($db);




$db->close();
?>

