<?php require("header.php"); ?>
		<div class=cnt>
			<center>
			</center>
			<div style="float:left;width:100px;height:500px;">
			</div>
			<?php
			require("connect.php");
			$sql = "select challname, status from round where username='" . $username . "'";
			if (!$result = $db->query($sql)) {
				echo "Query: " . $sql . "\n";
				echo "Errno: " . $db->errno . "\n";
				echo "Error: " . $db->error . "\n";
				exit;
			}
			while($row = $result->fetch_row()){
				$challname = $row[0];
				$status = $row[1];
				echo "<div style='float:left;width:200px;height:500px;background-color:#88ff70'>";
				echo "<div style='height:20%;'>";
				echo "<center>";
				echo $challname;
				echo "</center>";
				echo "</div>";
				echo "<hr>";
				echo "<div style='height:20%;'>";
				echo "<center>";
				echo $status;
				echo "</center>";
				echo "</div>";
				echo "<hr>";
				$sql = "select playername, playerpassword from player where username='" . $username . "'";
				if ($playerres = $db->query($sql) ){
					if($playerres->num_rows != 0) {
						$playerrow = $playerres->fetch_row();
						$playername = $playerrow[0];
						$playerpassword = $playerrow[1];
						echo "<div style='height:20%;'>";
						echo "<p align=center><b>SSH info</b></p>";
						echo "<p><b>Username :</b></p>";
						echo "<p>";
						echo $playername;
						echo "</p>";
						echo "<p><b>Password :</b></p>";
						echo "<p>";
						echo $playerpassword;
						echo "</p>";
						echo "</div>";
					}
				}

				echo "</div>";
				echo "<div style='float:left;width:50px;height:500px;'>";
				echo "</div>";
			}
			?>



		</div>
<?php require("footer.php"); ?>
