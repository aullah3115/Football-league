<?php
session_start();
include 'includes/checklog.inc.php';
include 'includes/connect.inc.php';

if(!isset($_POST)){
  header('Location: dashboard.php');
  exit();
}

$league_id = (int)$_SESSION['league_id'];
$query = "SELECT * FROM teams WHERE league_id='". $league_id ."';";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Teams</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1>Teams</h1>
  <form method="post" action="leaguedashboard.php">
    <input type="submit" name="submit" value="Go Back">
  </form>
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
</html>
