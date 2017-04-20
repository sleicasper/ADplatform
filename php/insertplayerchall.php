<?php
$playername = $argv[1];
$challname = $argv[2];
$port = $argv[3];
$pcapdirname = str_replace('/', '1', base64_encode(random_bytes(9)));
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
$sql = "insert into playerchall(playername, challname, port) values('" . $playername . "', '" . $challname . "', " . $port . ")";
$res = execsql($db, $sql);
$db->close();
?>

