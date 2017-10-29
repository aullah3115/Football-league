<?php
session_start();
include '../includes/connect.inc.php';
include '../includes/checklog.inc.php';

// check to see form has been submitted

if (!isset($_POST)){
  header('Location ../dashboard.php');
  exit();
}

$event = array_search("delete", $_POST);
$match_id = (int)$_SESSION['match_id'];
$query = "DELETE FROM match_events WHERE event_no =". $event;
$conn->query($query);

$query = "UPDATE matches SET status = 'changed' WHERE match_id = " . $match_id . ";";
$conn->query($query);

header('Location: ../match.php?status=removed');
