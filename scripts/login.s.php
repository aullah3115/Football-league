<?php
session_start();

include_once '../includes/connect.inc.php';

if (!isset($_POST['submit'])) {
	header("Location: ../login.php");
	exit();
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(empty($email) || empty($password)){
  header("Location: ../login.php?status=empty");
	exit();
}

$query = "SELECT * FROM users WHERE user_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
//$stmt->close();

if ($num_of_rows < 1) {
  header("Location: ../login.php?status=not_found");
	exit();
}

$row = $result->fetch_assoc();
$storedPassword = $row['user_password'];

if (password_verify($password, $storedPassword)){
  $_SESSION['logged'] = true;
  $_SESSION['name'] = $row['user_first_name'] . ' ' . $row['user_last_name'];
  $_SESSION['id'] = $row['user_id'];
  $_SESSION['email'] = $row['user_email'];
  header("Location: ../dashboard.php");
	exit();
} else {
  header("Location: ../login.php?status=error");
	exit();
}


?>
