<?php
require("connect.php");
$sql = "drop user 'monitor'@'localhost'";
if (!$result = $db->query($sql)) {
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $db->errno . "\n";
    echo "Error: " . $db->error . "\n";
    exit;
}
$sql = "drop database monitor";
if (!$result = $db->query($sql)) {
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $db->errno . "\n";
    echo "Error: " . $db->error . "\n";
    exit;
}
$db->close();
?>
