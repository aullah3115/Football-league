<?php
session_start();
if (!isset($_SESSION['logged'])){
header("Location: login.php");
exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
</head>
<body>
<?php
echo 'Welcome, ' . $_SESSION['name'];
?>

<form method="post" action="createleague.php">
  <input type="submit" name="makeleague" value="Create New League">
</form>
<form method="post" action="includes/logout.inc.php">
  <input type=submit name="logout" value="Log out">
<form>
</body>
</html>
