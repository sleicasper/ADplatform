<?php
$challname = $argv[1];
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
$sql = "insert into chall(challname) values('" . $challname . "')";
$res = execsql($db, $sql);
$db->close();
?>

