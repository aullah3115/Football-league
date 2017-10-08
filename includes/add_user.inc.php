<?php
session_start();
include_once 'connect.inc.php';
if (!isset($_POST['submit'])) {
	header("Location: ../register.php");
	exit();
} else {

	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	if (empty($first) || empty($last) || empty($email) || empty($password)) {
		header("Location: ../register.php?status=empty");
		exit();
	} else {
		$query = "SELECT * FROM users WHERE user_email = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$num_of_rows = $result->num_rows;
		$stmt->close();

		if ($num_of_rows > 0){
			header("Location: ../register.php?status=user_exists");
			exit();
		} else {
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$query = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password) VALUES (?,?,?,?);";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssss", $first, $last, $email, $hashedPassword);
			$stmt->execute();
			$stmt->close();

			//get user details from database

			$query = "SELECT * FROM users WHERE user_email = ?;";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$result = $stmt->get_result();

			$row = $result->fetch_assoc();

			$_SESSION['logged'] = true;
			$_SESSION['name'] = $row['user_first_name'] . ' ' . $row['user_last_name'];
			$_SESSION['id'] = $row['user_id'];
			$_SESSION['email'] = $row['user_email'];

			header("Location: ../dashboard.php");
			exit();
		}
	}
}
