<?php
$password = file_get_contents("../mysqlpass.txt");
$password = str_replace("\n", "", $password);
$db = new mysqli('127.0.0.1', 'root', $password, "monitor");
if ($db->connect_errno) {
    echo "Errno: " . $db->connect_errno . "\n";
    echo "Error: " . $db->connect_error . "\n";
    exit;
}
function execsql($db, $sql){
	if (!$result = $db->query($sql)) {
	    echo "Query: " . $sql . "\n";
	    echo "Errno: " . $db->errno . "\n";
	    echo "Error: " . $db->error . "\n";
	    exit;
	}
	return $result;
}
$sql = "select flag from flag";
$res = execsql($db, $sql);
while($row = $res->fetch_row()){
	printf("%s\n", $row[0]);
}


$db->close();
?>

