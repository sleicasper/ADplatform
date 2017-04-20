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
$sql = "select username from player";
$tmp = execsql($db, $sql);
$usernames = $tmp->fetch_all();


foreach( $challnames as $challname){
	$sql = "select username, score from scoreboard where challname='".$challname[0]."'";
	$tmp = execsql($db, $sql);
	$oldscores = $tmp->fetch_all();
	$newscores = array();
	foreach($oldscores as $oldscore){
		$newscores[$oldscore[0]] = $oldscore[1];
	}
	foreach( $usernames as $defender){
		//clear all status
		$sql = "update round set status='good' where  username='".$defender[0]."' and challname='".$challname[0]."'";
		execsql($db, $sql);

		$sql = "select attacker from roundhistory where challname='".$challname[0]."' and pwned=1 and defender='".$defender[0]. "'";
		$tmp = execsql($db, $sql);
		$attackers = $tmp->fetch_all();
		$attackernum = sizeof($attackers);
		if( $attackernum != 0 ){
			$points = 15/$attackernum;
			$newscores[$defender[0]] = $newscores[$defender[0]] - 15;
			foreach($attackers as $attacker){
				$newscores[$attacker[0]] = $newscores[$attacker[0]] + $points;
			}
			if( $newscores[$defender[0]] < 0)
				$newscores[$defender[0]] = 0;
			
		}

	}
	foreach( $usernames as $username){
		$sql = "update scoreboard set score=".$newscores[$username[0]]." where  username='".$username[0]."' and challname='".$challname[0]."'";
		execsql($db, $sql);
	}
	
}

foreach( $challnames as $challname){
	foreach( $usernames as $defender){
		$sql = "select * from roundhistory where challname='".$challname[0]."' and down=1 and defender='".$defender[0]. "'";
		$tmp = execsql($db, $sql);
		if($tmp->num_rows != 0){
			$sql = "update scoreboard set score=score-15 where  username='".$defender[0]."' and challname='".$challname[0]."'";
			execsql($db, $sql);
			
		}
		
	}
}




$sql = "delete from roundhistory";
$tmp = execsql($db, $sql);
$db->close();
?>

