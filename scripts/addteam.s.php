<?php
session_start();
include '../includes/checklog.inc.php';
include '../includes/connect.inc.php';

if (!isset($_SESSION['league_id'])){
  header('Location: ../dashboard.php');
  exit();
}

if (!isset($_POST)){
  header('Location: ../dashboard.php');
  exit();
}

//variables
$team = mysqli_real_escape_string($conn, $_POST['team']);
$league = (int)$_SESSION['league_id'];

if (empty($team)){
  header('Location: ../editteams.php?status=empty');
  exit();
}

// see if the team exists

$query = "SELECT * FROM teams WHERE team_name = ? AND league_id ='" . $league . "';";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $team);
$stmt->execute();
$result = $stmt->get_result();

$num_of_rows = $result->num_rows;
$stmt->close();

// if it exists go back
if ($num_of_rows > 0){
  header("Location: ../editteams.php?status=team_exists");
  exit();
}
//delete dummy team if it exists
/*
$query = "SELECT * FROM teams WHERE team_name ='dummy_team' AND league_id='". $league ."';";
$result = $conn->query($query);
$num_rows = $result->num_rows;

if($num_rows>0){
  $query="DELETE FROM teams WHERE team_name='dummy_team' AND league_id='". $league ."';";
  $conn->query($query);
}
*/
//add the team to the league
$query = "INSERT INTO teams (team_name, league_id) VALUES (?, '". $league ."');";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $team);
$stmt->execute();
$stmt->close();

//count no of teams in league
$query = "SELECT COUNT(*) AS no_of_teams FROM teams WHERE league_id ='". $league ."';";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$no_of_teams = (int)$row['no_of_teams'];
$_SESSION['teamnum'] = $no_of_teams;

//set dummy team in teams table to true or false depending on num of teams

if($no_of_teams % 2 == 1) {
  $query = "UPDATE leagues SET league_dummy = 1 WHERE league_id ='". $league ."';";
  $conn->query($query);
} else {
  $query = "UPDATE leagues SET league_dummy=0 WHERE league_id ='". $league ."';";
  $conn->query($query);
}

$query = "SELECT * FROM leagues WHERE league_id ='". $league ."';";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$dummy=$row['league_dummy'];

$_SESSION['dummy']=$dummy;


// go back
header('Location: ../editteams.php?status=added');
exit();
?>
