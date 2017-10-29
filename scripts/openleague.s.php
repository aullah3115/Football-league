<?php
session_start();
include '../includes/checklog.inc.php';
include '../includes/connect.inc.php';

$league = array_search('Select', $_POST);

// set session for league_id
$query = "UPDATE teams SET status='' WHERE status='deleted' AND league_id =". $_SESSION['league_id'] .";";
$conn->query($query);

$query = "UPDATE teams SET status='' WHERE status='added' AND league_id =". $_SESSION['league_id'] .";";
$conn->query($query);

if (isset($_POST[$league])) {

  $league = base64_decode($league);
  $id =(int)$_SESSION['id'];

  $query = "SELECT * FROM leagues WHERE league_name = '" . $league . "' AND user_id = '" . $id ."';";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();

  $league_id = $row['league_id'];
  $league_name = $row['league_name'];

  $_SESSION['league_id'] = $league_id;
  $_SESSION['league_name'] = $league_name;

  header('Location: ../leaguedashboard.php');
  exit();
}

//delete league
$league = array_search('Delete', $_POST);

if(!isset($_POST[$league])){
  header('Location: ../leaguedashboard.php');
  exit();
}

$league = base64_decode($league);

$query = "DELETE FROM leagues WHERE league_name = '" . $league . "' AND user_id = '" . $_SESSION['id'] ."';";
$conn->query($query);

header('Location: ../leagues.php?status=deleted');
exit();
?>
