<?php
session_start();
include 'includes/checklog.inc.php';

?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1>Home</h1>
  <h3>
<?php
echo 'Welcome, ' . $_SESSION['name'];
?>
</h3>

<form method="post" action="createleague.php">
  <input type="submit" name="makeleague" value="Create New League">
</form><br/>

<form method="post" action="leagues.php">
  <input type="submit" name="openleague" value="View My Leagues">
</form><br/>

<form method="post" action="includes/logout.inc.php">
  <input type=submit name="logout" value="Log out">
</form>
</body>
</html>
