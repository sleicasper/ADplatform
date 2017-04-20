<?php require("header.php"); ?>


		<div class=cnt>
			<center>
			<h1>Register</h1>
			<form action=register.php method=POST>
			<table width="0" border="0" cellspacing="0" cellpadding="0">

			<tr>
			<td>Username：</td>
			<td><input type="text" name="username"/></td>
			</tr>
			<tr>
			<td>Create Password： </td>
			<td><input type="password" name="pass"/></td>
			</tr>

			<tr>
			<td>Confirm Password：</td>
			<td><input type="password" name="confirmpass"/></td>
			</tr>

			<tr>
			<td colspan="2"><input type="submit" value="Register"/>
			</td>
			</tr>




			</table>
			</form>

			</center>

		</div>
<?php require("footer.php"); ?>

<?php
require("connect.php");
$username = $_POST['username'];
$pass = $_POST['pass'];
$confirmpass = $_POST['confirmpass'];
if( isset($username) and isset($pass) and isset($confirmpass) ){
	$pattern = "/^([0-9A-Za-z]+)$/";
        if ( !preg_match( $pattern, $username) )
        {
		echo "<script>alert(\"Illegal Username\")</script>";
		echo "<script>location.href=\"register.php\"</script>";
		exit;
	}
        if ( !($pass === $confirmpass) )
        {
		echo "<script>alert(\"Password must match\")</script>";
		echo "<script>location.href=\"register.php\"</script>";
		exit;
	}
	$pattern = "/^([0-9A-Za-z\\-_\\.]+)$/";
        if ( !preg_match( $pattern, $pass) )
        {
		echo "<script>alert(\"Illegal password\")</script>";
		echo "<script>location.href=\"register.php\"</script>";
		exit;
	}
	$sql = "select count(*) from player";
	if (!$result = $db->query($sql)) {
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $db->errno . "\n";
		echo "Error: " . $db->error . "\n";
		exit;
	}
	$playername = "ctf" . ($result->fetch_row()[0]);
	$salt = base64_encode(random_bytes( 9 ));
	$pass = sha1($pass . $salt);
	$pcapdirname = sha1( random_bytes(20) );
	$sql = "insert into player(username, password, salt, playername, pcapdirname) values('" . $username. "','" . $pass . "','" . $salt . "','" .$playername . "', '" . $pcapdirname . "')";
	if (!$result = $db->query($sql)) {
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $db->errno . "\n";
		echo "Error: " . $db->error . "\n";
		exit;
	}

	echo "<script>alert(\"register success\")</script>";
	echo "<script>location.href=\"login.php\"</script>";

	$db->close();
}
?>
