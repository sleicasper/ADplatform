<html>
	<head>
		<title>Attack Defence Platform</title>
		<style>
			a:link {color: #e8f0ff}
			a:visited {color: #e8f0ff}
			a:hover {color: #e8f0ff}
			a:active {color: #e8f0ff}
			body{
				font-family:DejaVu Sans, Helvetica Neue, Verdana, Arial, WenQuanYi Micro Hei, LiHei Pro, AR PLMingU20 Light, Microsoft YaHei, sans-serif;
				background-color: #e8f0ff;
				font-weight:normal
			}
			.ttl{
				height:80px;
				background-color: #684401;
				color:#d8f4ff;
			}
			.cnt{
				height:85%;
			}
			.ftr{
				height:5%;
			}
		</style>
	</head>

	<body>
		<div class=ttl>
			<div style="width:95%;margin:0 auto;">
				<div style="float:left;width:40%;font-size:30">
					<i>Attack Defence Platform</i>
				</div>
				<div style="float:left;width:20%; height:60px;line-height:60px;overflow:hidden;">
					<?php session_start();
						$username = $_SESSION['username'];
						echo "<a href='game.php'>" . $username . "</a>";
					?>
				</div>
				<div style="float:left;width:20%; height:60px;line-height:60px;overflow:hidden;">
					<?php
						session_start();
						require("connect.php");
						$res=$db->query("select round from game");
						$row = $res->fetch_row();
						echo "Round: ".$row[0];
					?>
				</div>
				<div style="float:left;width:20%; height:100%;line-height:30px;overflow:hidden;">
					<div style="float:right;width:25%;font-family:Helvetica;">
						<div>
							<a href='scoreboard.php'><u><i>Scoreboard</i></u></a>
						</div>
						<div style="margin-right:0px;float:right">
						<?php
							session_start();
							$username = $_SESSION['username'];
							if( !isset($username) ){
								echo "<a href='login.php'><u><i>Login</i></u></a>";
							}
							else{
								echo "<a href='logout.php'><u><i>Logout</i></u></a>";
							}


						 ?>
						</div>
					</div>
					<div style="float:right;width:35%;">
						<div>
						<?php
							session_start();
							$username = $_SESSION['username'];
							if(isset($username)){
								$sql = "select pcapdirname from player where username='" . $username . "'";
								if (!$result = $db->query($sql)) {
									echo "Query: " . $sql . "\n";
									echo "Errno: " . $db->errno . "\n";
									echo "Error: " . $db->error . "\n";
									exit;
								}
								$row = $result->fetch_row();
								$pcapdirname = $row[0];
								printf("<a href='pcap/%s'><u><i>Pcap Download</i></u></a>", $pcapdirname);
							}
							else{
								printf("<a><u><i>Pcap Download</i></u></a>", $pcapdirname);
							}
						?>
						</div>
						<div style="float:left;width:50%">
							<a href='event.php'><u><i>Event</i></u></a>
						</div>
						<div style="float:right;width:50%">
							<a href='Help.php'><u><i>Help</i></u></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
