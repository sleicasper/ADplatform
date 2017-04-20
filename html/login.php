<?php require("header.php"); ?>

		<div class=cnt>
			<center>
			<h1>Login</h1>
			<form action=login.php method=POST>
			<table width="0" border="0" cellspacing="0" cellpadding="0">

			<tr>
			<td>Username：</td>
			<td><input type="text" name="username"/></td>
			</tr>
			<tr>
			<td>Password： </td>
			<td><input type="password" name="pass"/></td>
			</tr>

			<tr>
			<td colspan="2"><input type="submit" value="login"/>
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
if( isset($username) and isset($pass) ){
	$pattern = "/^([0-9A-Za-z]+)$/";
        if ( !preg_match( $pattern, $username) )
        {
		echo "<script>alert(\"Illegal Username\")</script>";
		echo "<script>location.href=\"login.php\"</script>";
	}
	$pattern = "/^([0-9A-Za-z\\-_\\.]+)$/";
        if ( !preg_match( $pattern, $pass) )
        {
		echo "<script>alert(\"Illegal password\")</script>";
		echo "<script>location.href=\"login.php\"</script>";
	}
	
	$sql = "select password, salt from player where username='" . $username . "'";
	if (!$result = $db->query($sql)) {
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $db->errno . "\n";
		echo "Error: " . $db->error . "\n";
		exit;
	}
	$row = $result->fetch_row();
        $password = $row[0];
	$salt = $row[1];
	if( !($password === sha1($pass . $salt) ) ){
		echo "<script>alert(\"login fail\")</script>";
		echo "<script>location.href=\"index.php\"</script>";
	}
	else{
		session_start();
		$_SESSION['username'] = $username;
		$db->close();
		echo "<script>alert(\"login success\")</script>";
		echo "<script>location.href=\"index.php\"</script>";
	}
}
?>
