<?php
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
$sql = "select challname,username,playername from player,chall";
$res = execsql($db, $sql);
while($row = $res->fetch_row()){
	$challname = $row[0];
	$username = $row[1];
	$playername = $row[2];
	$flag = "ctf{" . sha1(random_bytes(100)) . "}";
	$sql = "update flag set flag='" . $flag . "' where challname='" . $challname . "' and username='" . $username . "'";
	execsql($db, $sql);
	$sername = $playername . "_" . $challname;
	$pwd = "/home/" . $sername . "/flag.txt";

	$cmd = "chattr -i " . $pwd;
	system($cmd);
	$cmd = "echo " . $flag . " > " . $pwd;
	system($cmd);
	$cmd = "chmod 700 ".$pwd;
	system($cmd);
	$cmd = "chown " . $sername . " " . $pwd;
	system($cmd);
	$cmd = "chattr +i " . $pwd;
	system($cmd);
}

$sql = "update game set round=round+1";
execsql($db, $sql);


$db->close();
?>

