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
$sql = "select challname from chall";
$tmp = execsql($db, $sql);
$challnames = $tmp->fetch_all();
$sql = "select username, playername from player";
$tmp = execsql($db, $sql);
$usernames = $tmp->fetch_all();


foreach( $challnames as $challname){
	foreach( $usernames as $defender){
		$sql = "select port from playerchall where  playername='".$defender[1]."' and challname='".$challname[0]."'";
		$port = ((execsql($db, $sql))->fetch_row())[0];
		$cmd = "check/" . $challname[0] . ".py " . $port;
		system($cmd, $ret);
		var_dump($ret);
	
		if($ret == 1){
			$sql = "insert into roundhistory(defender, challname, attacker, pwned, down) values('".$defender[0]."', '".$challname[0]."', '', 0, 1)";
			execsql($db, $sql);
			$sql = "select status from round where  username='".$defender[0]."' and challname='".$challname[0]."'";
			$status = ((execsql($db, $sql))->fetch_row())[0];
			if( $status == "good" )
				$sql = "update round set status='down' where  username='".$defender[0]."' and challname='".$challname[0]."'";
			else if( $status == "pwned" )
				$sql = "update round set status='pwned_down' where  username='".$defender[0]."' and challname='".$challname[0]."'";
			else if( $status == "pwned_down" )
				continue;
			execsql($db, $sql);
		}
	}
}
$db->close();
?>

