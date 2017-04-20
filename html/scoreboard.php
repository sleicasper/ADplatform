<?php require("header.php"); ?>
		<div class=cnt>
			<center>
			<table >
				<tr>
				<th width=80> Team </th>
				<th width=80> Score </th>
				<?php
					require("connect.php");
					$sql = "select challname from chall";
					$challres = $db->query($sql);
					while ($row = $challres->fetch_row()) {
						echo "<th width=80>" . $row[0] . "</th>";
					}
					
				?>
				</tr>
				<?php
					function execsql($db, $sql){
						if (!$result = $db->query($sql)) {
						    echo "Query: " . $sql . "\n";
						    echo "Errno: " . $db->errno . "\n";
						    echo "Error: " . $db->error . "\n";
						    exit;
						}
						return $result;
					}
					require("connect.php");
					$sql = "select username from scoreboard group by username order by sum(score) desc";
					$userres = execsql($db,$sql);
					while ($userrow = $userres->fetch_row()) {
						$user = $userrow[0];
						echo "<tr>";
						echo "<th width=80>" . $user . "</th>";


						$sql = "select sum(score) from scoreboard where username='".$user."'";
						$sumscore = $db->query($sql);
						echo "<th width=80>" . $sumscore->fetch_row()[0] . "</th>";


						$sql = "select challname from chall";
						$challres = $db->query($sql);
						while ($challrow = $challres->fetch_row()) {
							$sql = "select score from scoreboard where username='".$user."' and challname='" . $challrow[0] . "'";
							$scoreres = execsql($db,$sql);
							echo "<th width=80>" . $scoreres->fetch_row()[0] . "</th>";
						}

						echo "</tr>";
				
					}

				?>
			</table>


			</center>



		</div>
<?php require("footer.php"); ?>
