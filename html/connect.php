	<?php
	$db = new mysqli('127.0.0.1', 'monitor', '3f65c1223e5c8ca4cf20089d486d9ba4487c7f2b');
	if ($db->connect_errno) {
		echo "Errno: " . $db->connect_errno . "\n";
		echo "Error: " . $db->connect_error . "\n";
		exit;
	}
	$sql = "use monitor";
	if (!$result = $db->query($sql)) {
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $db->errno . "\n";
		echo "Error: " . $db->error . "\n";
		exit;
	}
	?>