<?php
session_start();
if(isset($_POST)){
$_SESSION = array();
header('Location: /football/index.php');
}
?>
