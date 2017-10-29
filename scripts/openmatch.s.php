<?php
session_start();
include 'includes/connect.inc.php';
include 'includes/checklog.inc.php';

if (!isset($_POST)){
  header('Location: leaguedashboard.php');
}

$match_id = array_search('Select', $_POST);

$_SESSION['match_id'] = $match_id;

header('Location: ../match.php');
exit();
?>
