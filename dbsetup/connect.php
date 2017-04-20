<?php
$password = file_get_contents("mysqlpass.txt");
$password = str_replace("\n", "", $password);
$db = new mysqli('127.0.0.1', 'root', $password);
if ($db->connect_errno) {
    echo "Errno: " . $db->connect_errno . "\n";
    echo "Error: " . $db->connect_error . "\n";
    exit;
}
?>
