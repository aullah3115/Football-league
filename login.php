<?php
session_start();
if(isset($_SESSION['logged'])){
  header('Location: dashboard.php');
}
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Log in</title>
</head>
<body>
	<div>
<form method="post" action="includes/login.inc.php">
	<input type="text" name="email" placeholder="E-mail">
	<input type="text" name="password" placeholder="Password">
	<input type="submit" name="submit" value="Log in">
</form>
<a href="register.php">Create New Account</a>
</div>
</body>
</html>
