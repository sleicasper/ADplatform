<?php
//change password 
$playername = $argv[1];
$playerpassword = $argv[2];
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
$sql = "update player set playerpassword='" . $playerpassword . "' where playername='" . $playername . "'";
$res = execsql($db, $sql);
$db->close();
?>

