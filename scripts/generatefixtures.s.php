<?php
session_start();

include '../includes/checklog.inc.php';
include '../includes/connect.inc.php';

if(!isset($_POST['submit'])) {
  header('Location: ../dashboard.php?error');
  exit();
}
//find out number of teams in league

if (!isset($_SESSION['league_id'])){
  $link = 'Location: ../dashboard.php?' . $_SESSION['league_id'];
  header($link);
  exit();
}

$league_id = $_SESSION['league_id'];

$query = "SELECT league_dummy FROM leagues WHERE league_id='". $league_id ."';";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$dummy = $row['league_dummy'];

// get team ids and store in array
$teams = array();

$query = "SELECT team_id FROM teams WHERE league_id = '". $league_id ."';";
$result = $conn->query($query);

while($row = $result->fetch_assoc()){
  $teams[] = $row['team_id'];
}

if($dummy==1){
  $teams[] = "dummy";
}

//generate fixtures

// store fixtures in matches table

// go to next stage

//(header 'Location: ../leaguedashboard.php')

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <?php
  //echo $no_of_teams . '<br/>';
  //echo $num_of_rows . '<br/>';
  echo $dummy;
  echo '<li>';
  foreach($teams as $team){
    echo '<ul>' . $team . '</ul>';
  }
  echo '</li>';
  ?>
</body>
</html>
