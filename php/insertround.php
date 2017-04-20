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
$sql = "select challname,username from player, chall";
$res = execsql($db, $sql);
while($row = $res->fetch_row()){
	$challname = $row[0];
	$username = $row[1];
	$sql = "insert into round(challname, username, status) values('" . $challname . "', '". $username . "', 'good')";
	execsql($db, $sql);
	
}


$db->close();
?>

