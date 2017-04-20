<?php require("header.php"); ?>
		<div class=cnt>
			<center>
			<?php session_start();
				$username = $_SESSION['username'];
				if( !isset($username) ){
					echo "<h1><a style='color:black' href='register.php'>Register</a></h1>"; 
				}
				else{
					echo "<h1>Welcome " . $username . "</h1>"; 
				}

			?>

			</center>



		</div>
<?php require("footer.php"); ?>
