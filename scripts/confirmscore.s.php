<?php
session_start();
include '../includes/connect.inc.php';
include '../includes/checklog.inc.php';

if (!isset($_POST)){
  header('Location: ../leaguedashboard.php');
}

$match_id = (int)$_SESSION['match_id'];

$query = "UPDATE matches SET status = 'played' WHERE match_id = " . $match_id . ";";
$conn->query($query);


header('Location: ../match.php?status=confirmed');
