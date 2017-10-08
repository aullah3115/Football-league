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
include 'connect.inc.php';

$name = mysqli_real_escape_string($conn, $_POST['name']);
$num = (int)$_POST['number'];

if (empty($name) || empty($num)) {
  header('Location: ../createleague.php?status=empty');
  exit();
}

if (!is_int($num)) {
  header('Location: ../createleague.php?status=non_int');
  exit();
}

$user_id=(int)$_SESSION['id'];

$query = "SELECT * FROM leagues WHERE user_id = ? AND league_name = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $user_id, $name);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = $result->num_rows;
$stmt->close();

if($num_rows > 0){
  header('Location: ../createleague.php?status=league_exists');
  exit();
}

$query = "INSERT INTO leagues (league_name, league_year, user_id) VALUES (?, YEAR(CURDATE()), ?);";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $name, $user_id);
$stmt->execute();
$stmt->close();

$query = "SELECT * FROM leagues WHERE user_id = ? AND league_name = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $user_id, $name);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();

$_SESSION['league_id'] = $row['league_id'];
$_SESSION['league_name'] = $name;
$_SESSION['num_teams'] = $num;
header('Location: ../add_teams.php');
exit();


 ?>
