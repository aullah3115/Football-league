<?php
session_start();
include '../includes/connect.inc.php';
include '../includes/checklog.inc.php';

$team_id = (int)$_SESSION['team_id'];
$user_id = (int)$_SESSION['id'];

//check to see if form was submitted

if(!isset($_POST)){
  header('Location: ../dashboard.php?status=unsubmitted1');
  exit();
}

if (isset($_POST['addplayer'])){
$first = mysqli_real_escape_string($conn, $_POST['first']);
$last = mysqli_real_escape_string($conn, $_POST['last']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

// check to see if input field is empty
if(empty($first) || empty($last)){
  header('Location: ../addplayer.php?status=empty');
  exit();
}

// check to see if player of that name already exists for current user

$query = "SELECT player_id, player_first, player_last, user_id FROM players
WHERE player_first= ? AND player_last=? AND user_id=".$_SESSION['id'].";";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $first, $last);
$stmt->execute();
//$result = $stmt->get_result();
$stmt->store_result();
$num_rows = $stmt->num_rows;
//$row=$result->fetch_assoc();
//$num_rows = $result->num_rows;

if($num_rows > 0) {
  header('Location: ../addplayer.php?status=exists');
  exit();
}

// insert player into players table

$query = "INSERT INTO players (player_first, player_last, player_email, player_phone, user_id)
VALUES (?,?,?,?," . $user_id . ");";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssss', $first, $last, $email, $phone);
$stmt->execute();

// get new player's id from players table

$query = "SELECT player_id FROM players
WHERE player_first= ? AND player_last=?;";

$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $first, $last);
$stmt->execute();
$stmt->bind_result($pid);
$stmt->fetch();
$player_id = (int)$pid;
//$result = $stmt->get_result();
//$row = $result->fetch_assoc();
//$player_id = $row['player_id'];

// check to see if the player added is already in current team

$query = "SELECT * FROM player_team WHERE player_id=". $player_id ." AND team_id=". $team_id .";";
$result = $conn->query($query);
$num_rows = $result->num_rows;

if ($num_rows > 0){
  header('Location: ../addplayer.php?status=present');
  exit();
}

// add player to selected team

$query = "INSERT INTO player_team (player_id, team_id) VALUES (" . $player_id ."," . $team_id . ");";
$conn->query($query);

header('Location: ../addplayer.php?status=added');
exit();
}

// add an existing player to current team

if (!isset($_POST['submit'])) {
  header('Location: ../dashboard.php?status=unsubmitted2');
  exit();
}
$player_id = (int)$_POST['player'];

$query = "INSERT INTO player_team (team_id, player_id) VALUES (". $team_id .", ". $player_id .");";
$conn->query($query);

header('Location: ../addplayer.php?status=added2');
exit();
?>
