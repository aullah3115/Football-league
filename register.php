<!DOCTYPE html>
<html>
<head>
<title>Register</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1>Create New Account</h1>
  <form action="index.php" method="post">
    <input type="submit" name="submit" value="Back to Home Page">
  </form><br/>
	<div>
<form method="post" action="scripts/adduser.s.php">
	<input type="text" name="first" placeholder="First Name"><br/><br/>
	<input type="text" name="last" placeholder="Last Name"><br/><br/>
	<input type="text" name="email" placeholder="E-mail"><br/><br/>
	<input type="password" name="password" placeholder="Password"><br/><br/>
  <input type ="radio" name="access" value="basic" checked> Basic   Not yet implemented<br/>
  <input type ="radio" name="access" value="premium"> Premium<br/>
	<input type="submit" name="submit" value="Create User"><br/>
</form>
</div>
</body>
</html>
