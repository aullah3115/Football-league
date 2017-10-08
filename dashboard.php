<?php
session_start();
include 'includes/checklog.inc.php';

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

<form method="post" action="leagues.php">
  <input type="submit" name="openleague" value="My Leagues">
</form>

<form method="post" action="includes/logout.inc.php">
  <input type=submit name="logout" value="Log out">
</form>
</body>
</html>
