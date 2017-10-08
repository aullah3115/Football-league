<?php
if(!isset($_SESSION['league_id'])){
  header('Location: dashboard.php');
  exit();
}

if(!isset($_POST['addteam'])){
  exit();
}

$team = mysqli_real_escape_string($conn, $_POST['team']);

if(!empty($team)){


$query = "SELECT * FROM teams WHERE team_name = ? AND league_id = ". $_SESSION['league_id'];
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $team);
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
$stmt->close();


if($num_of_rows > 0) {
    exit();
}
$league = (int)$_SESSION['league_id'];
$query = "INSERT INTO teams (team_name, league_id) VALUES (?,?);";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $team, $league );
$stmt->execute();
$team_id = $conn->insert_id;
$stmt->close();
}
?>
