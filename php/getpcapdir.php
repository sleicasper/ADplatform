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
$sql = "select pcapdirname from player";
$res = execsql($db, $sql);
while($row = $res->fetch_row()){
	printf("%s ", $row[0]);
}


$db->close();
?>

