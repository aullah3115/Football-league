<?php
session_start();
include 'includes/checklog.inc.php';

 ?>
<!DOCTYPE>
<html>
<head>
  <title>Create New League</title>
</head>
<body>
  <form method="post" action="scripts/createleague.s.php">
    <input type="text" name="name" placeholder="Enter league name"><br/>
    <input type="text" name="weeks" placeholder="Number of weeks"><br/>
    <input type="text" name="rounds" placeholder="Number of rounds per week"><br/>
    <input type="submit" name="create" value="Create League">
  </form>



  <form method="post" action="includes/logout.inc.php">
    <input type=submit name="logout" value="Log out">
  </form>
</body>
</html>
