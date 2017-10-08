<?php
if (!isset($_POST)) {
  header('Location: ../index.php');
}
session_start();
$_SESSION = array();
header('Location: ../index.php');
 ?>
