<?php
if (!isset($_SESSION['logged'])){
  header('Location: \Football\index.php');
  exit();
}
?>
