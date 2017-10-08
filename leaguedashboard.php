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
<body>
<h1><?php echo $_SESSION['league_name'];?></h1>

<form method="post" action="includes/logout.inc.php">
  <input type="submit" name="editteams" value="Log Out">
</form>

<form method="post" action="leagues.php">
  <input type="submit" name="changeleague" value="Choose a different League">
</form>

<form method="post" action="editteams.php">
  <input type="submit" name="editteams" value="Add/Delete Teams">
</form>
<h4>Teams</h4>
<?php
while($row = $result->fetch_assoc()){
  $team = $row['team_name'];
  echo '<label>'. $team . '</label><br/>';
}
?>
</body>
</html
