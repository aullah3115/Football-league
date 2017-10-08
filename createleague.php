<?php
session_start();
if (!isset($_SESSION['logged'])){
  header('Location: index.php');
  exit();
}
 ?>
<!DOCTYPE>
<html>
<head>
  <title>Create New League</title>
</head>
<body>
  <form method="post" action="includes/createleague.inc.php">
    <input type="text" name="name" placeholder="Enter league name">
    <input type="number" name="number" placeholder="Enter number of teams" min="2" max="50">
    <input type="submit" name="create" value="Create League">
  </form>
</body>
</html>
