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
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1>Log in</h1>
	<div>
<form method="post" action="scripts/login.s.php">
	<input type="text" name="email" placeholder="E-mail">
	<input type="text" name="password" placeholder="Password"><br/><br/>
	<input type="submit" name="submit" value="Log in">
</form><br/>
<a href="register.php">Create New Account</a>
</div>
</body>
</html>
