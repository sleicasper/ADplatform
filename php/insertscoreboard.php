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
$sql = "select username,challname from player,chall";
$ores = execsql($db, $sql);
while($row = $ores->fetch_row()){
	$sql = "insert into scoreboard(challname, username, score) values('" . $row[1] ."', '" . $row[0] . "', 1000)";
	execsql($db, $sql);
}


$db->close();
?>

