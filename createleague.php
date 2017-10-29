<?php
session_start();
include 'includes/checklog.inc.php';

 ?>
<!DOCTYPE>
<html>
<head>
  <title>Create New League</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1>Create a New League</h1>

  <form method="post" action="dashboard.php">
    <input type=submit name="submit" value="Go Back">
  </form>

  <form method="post" action="includes/logout.inc.php">
    <input type=submit name="logout" value="Log out">
  </form>

  <form method="post" action="scripts/createleague.s.php">
    <input type="text" name="name" placeholder="Enter league name">League Name<br/>
    <input type="text" name="weeks" placeholder="Number of weeks">Number of weeks (select 1 for standard round robin)<br/>
    <input type="text" name="rounds" placeholder="Number of rounds per week" autocomplete="off">Rounds per week(1 is single round robin, 2 is double, more is also possible)<br/>
    <input type="radio" name="public" value="public">Make league publicly viewable (Not yet implemented)<br/>
    <input type="radio" name="public" value="private">Make league invisible (Not yet implemented)<br/>
    <input type="password" name="password" placeholder="Password" autocomplete="off">Only add for private leagues<br/>
    <input type="submit" name="create" value="Create League">
  </form>

</body>
</html>
