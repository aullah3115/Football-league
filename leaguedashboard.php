<?php
session_start();
include 'includes/checklog.inc.php';
include 'includes/connect.inc.php';

if (!isset($_SESSION['league_id'])){
  header('Location: dashboard.php?status=' . $_SESSION['league_id']);
  exit();
}

$league_id = (int)$_SESSION['league_id'];
$query = "SELECT * FROM teams WHERE league_id='". $league_id ."';";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html>
<head>
</head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
<body>
<h1><?php echo $_SESSION['league_name'];?></h1>

<form method="post" action="includes/logout.inc.php">
  <input type="submit" name="editteams" value="Log Out">
</form>

<form method="post" action="leagues.php">
  <input type="submit" name="changeleague" value="Choose a different League">
</form>
<hr>
<form method="post" action="editteams.php">
  <input type="submit" name="editteams" value="Add/Delete Teams">
</form>

<form method="post" action="editteamnames.php">
  <input type="submit" name="editteams" value="Change Team Names">
</form>
<hr>
<!--
<form method="post" action="teams.php">
  <input type="submit" name="viewteams" value="View Teams">
</form>
-->
<form method="post" action="fixtures.php">
  <input type="submit" name="viewfixture" value="View Fixtures">
</form>

<form method="post" action="standings.php">
  <input type="submit" name="viewtable" value="View League table">
</form>

<h4>TEAMS</h4>
<!--
<form>
<?php
/*
while($row = $result->fetch_assoc()){
  $team = $row['team_name'];
  echo '<label>'. $team . '</label><br/>';
}
*/
?>
</form>
-->
<form method="post" action="teamdashboard.php">
<?php
while($row = $result->fetch_assoc()){
  $team = $row['team_name'];
  echo '<label>'. $team . '</label>';

  $encode_team = base64_encode($team);
  echo '<input type="submit" name="' . $encode_team . '" value="View Team"><br/>';
  //echo '<input type="submit" name="' . $encode_team . '" value="Delete"><br/>';
}
?>
</form>
</body>
</html
