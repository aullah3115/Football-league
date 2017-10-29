
<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1>Welcome</h1>
	<h4>Warning! This site is currently in development and is not yet fully functional. There are many security issues which have not been yet been addressed. Therefore, if you wish to test out the website, please use fabricated data. Under no circumstances should you use your actual personal details.</h4>
	<p> This is the index page. Currently it allows the user to either login or register a new account. Details are stored in a MySQL Database.</p>
	<form method="post" action="register.php">
		<input type="submit" name="register" value="Register">
	</form>
	<p>This button takes the user to a page which will allow them to create a new account</p>
	<form action="login.php" method="post">
		<input type="submit" name="login" value="Log in">
	</form>
	<p>This button allows a user with an existing account to login</p>
	<h3>Things to do</h3>
	<ul>
	<li>Allow non-account holders to view leagues</li>
	<li>Add menu</li>
	<li>Make page more presentable with css</li>
	<li>Add javascript to make page interactive</li>
	</ul>
</body>
</html>
