<?php
session_start();
include '../includes/connect.inc.php';
include '../includes/checklog.inc.php';

if (!isset($_POST)){
  header('Location: ../leaguedashboard.php');
}

if (empty($_POST['event']) || empty($_POST['player'])) {
  header('Location: ../match.php?status=empty');
  exit();
}

$event_id = $_POST['event'];
$player_id = $_POST['player'];
$match_id = (int)$_SESSION['match_id'];

$query = "INSERT INTO match_events (match_id, player_id, event_id)
          VALUES (". $match_id .", ". $player_id .", ". $event_id .");";
$conn->query($query);
$_SESSION['error1'] = $conn->error;

$query = "UPDATE matches SET status = 'changed' WHERE match_id = " . $match_id . ";";
$conn->query($query);

header('Location: ../match.php?status=added');
exit();
?>
