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
$sql = "select challname,username from scoreboard";
$res = execsql($db, $sql);
while($row = $res->fetch_row()){
	$flag = "ctf{" . sha1(random_bytes(100)) . "}";
	$sql = "insert into flag values('" . $row[0] . "', '" . $row[1] . "', '" . $flag ."')";
	execsql($db, $sql);
}


$db->close();
?>

