<?php
$username = $argv[1];
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

$sql = "select port from player,playerchall where playerchall.playername=player.playername and player.username='" . $username . "'";
$res = execsql($db, $sql);
while($row = $res->fetch_row()){
	printf("%s ", $row[0]);
}


$db->close();
?>

