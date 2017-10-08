<?php
session_start();
if (!isset($_SESSION['logged'])){
  header('Location: ../index.php');
  exit();
}
if (!isset($_POST['create'])) {
  header('Location: ../dashboard.php');
  exit();
}
include '../includes/connect.inc.php';

//variables

$user_id=(int)$_SESSION['id'];
$name = mysqli_real_escape_string($conn, $_POST['name']);
$weeks = (int)mysqli_real_escape_string($conn, $_POST['weeks']);
$rounds = (int)mysqli_real_escape_string($conn, $_POST['rounds']);

if (empty($name) || empty($weeks) || empty($rounds)) {
  header('Location: ../createleague.php?status=empty');
  exit();
}

// check to see if league already exists

$query = "SELECT * FROM leagues WHERE user_id = '". $user_id ."' AND league_name = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $name);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = $result->num_rows;
$stmt->close();

if($num_rows > 0){
  header('Location: ../createleague.php?status=league_exists');
  exit();
}

// enter league details into leagues table

$query = "INSERT INTO leagues (league_name, league_year, league_weeks, league_rounds, user_id) VALUES (?, YEAR(CURDATE()), ?,  ?, ?);";
$stmt = $conn->prepare($query);
$stmt->bind_param('siii', $name, $weeks, $rounds, $user_id);
$stmt->execute();
$stmt->close();

// get and store league id and name as session variables

$query = "SELECT * FROM leagues WHERE user_id = ? AND league_name = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $user_id, $name);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$_SESSION['league_id'] = $row['league_id'];
$_SESSION['league_name'] = $name;

// go to next stage of adding teams

header('Location: ../editteams.php');
exit();


 ?>
