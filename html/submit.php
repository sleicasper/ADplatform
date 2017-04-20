<?php require("header.php"); ?>
		<div class=cnt>
			<center>
			<form action="submit.php" method="post">
			Input Flag Here: <input type="text" name="flag" /><br />
			<input type="submit" />
			</form>
			<?php
			session_start();
			$username = $_SESSION['username'];
			require("connect.php");
			$flag = $_POST['flag'];
			if(isset($flag) && isset($username)){
				$pattern = "/^([0-9A-Za-z\{\}]+)$/";
				if ( !preg_match( $pattern, $flag) )
				{
					echo "Wrong Flag";
		
				}
				else{
					$sql = "select challname,username from flag where flag='".$flag."' and username<>'".$username."'";
					if (!$result = $db->query($sql)) {
						echo "Query: " . $sql . "\n";
						echo "Errno: " . $db->errno . "\n";
						echo "Error: " . $db->error . "\n";
						exit;
					}
					if( 0 === $result->num_rows){
						echo "Wrong Flag";
					}
					else{
						$row = $result->fetch_row();
						$defender = $row[1];
						$challname = $row[0];
						$attacker = $username;
						$sql = "insert into roundhistory(defender, challname, attacker, pwned, down) values('" . $defender . "', '" . $challname . "', '" .$attacker . "', 1, 0)";
						if (!$result = $db->query($sql)) {
							echo "You already submit that flag";
						}
						else{
							echo "Correct Flag";
							$sql = "select status from round where  username='".$defender."' and challname='".$challname."'";
							if (!$statusres= $db->query($sql)) {
								echo "Query: " . $sql . "\n";
								echo "Errno: " . $db->errno . "\n";
								echo "Error: " . $db->error . "\n";
								exit;
							}
							$status = ($statusres->fetch_row())[0];
							if( $status == "good")
								$sql = "update round set status='pwned' where  username='".$defender."' and challname='".$challname."'";
							else if( $status == 'down')
								$sql = "update round set status='pwned_down' where  username='".$defender."' and challname='".$challname."'";
							if (!$sres= $db->query($sql)) {
								echo "Query: " . $sql . "\n";
								echo "Errno: " . $db->errno . "\n";
								echo "Error: " . $db->error . "\n";
								exit;
							}
							$sql = "select secret from game";
							if (!$sres= $db->query($sql)) {
								echo "Query: " . $sql . "\n";
								echo "Errno: " . $db->errno . "\n";
								echo "Error: " . $db->error . "\n";
								exit;
							}
							$srow = $sres->fetch_row();
							$secret = $srow[0];
							$jsonarg = json_encode(["attacker"=>$attacker, "defender"=>$defender, "chall"=>$challname]);
							$cmd = "/var/www/html/wsclient.py '".$secret.$jsonarg."'";
							system($cmd);
						}
					}
				}
			}
			?>
		</center>



		</div>
<?php require("footer.php"); ?>
