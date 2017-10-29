<?php
session_start();
include '../includes/checklog.inc.php';
include '../includes/connect.inc.php';

if(!isset($_POST)){
  header('Location: ../leaguedashboard.php');
  exit();
}

$query = "UPDATE teams SET status='' WHERE status='deleted' AND league_id =". $_SESSION['league_id'] .";";
$conn->query($query);

$query = "DELETE FROM teams where status='added' AND league_id =". $_SESSION['league_id'] . ";";
$conn->query($query);

header('Location: ../leaguedashboard.php');
?>
