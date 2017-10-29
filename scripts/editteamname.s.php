<?php
session_start();
include '../includes/connect.inc.php';
include '../includes/checklog.inc.php';

// check to see form has been submitted

if (!isset($_POST)){
  header('Location ../dashboard.php');
  exit();
}

$league = (int)$_SESSION['league_id'];
$oldteam = array_search('change', $_POST);
$oldteam = base64_decode($oldteam);

//find the id of the team selected

$query = "SELECT * FROM teams WHERE team_name ='".$oldteam."' AND league_id='".$league."';";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$id = $row['team_id'];

$newteam=$_POST[$id];
$ewteam = mysqli_real_escape_string($conn, $newteam);

$_SESSION['newteam'] = $newteam;
$_SESSION['oldteam'] = $oldteam;

if (empty($newteam)){
  header('Location: ../editteamnames.php?status=empty');
  exit();
}

// see if a team with the new name already exists

$league = (int)$_SESSION['league_id'];
$query = "SELECT * FROM teams WHERE team_name = ? AND league_id ='" . $league . "';";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $newteam);
$stmt->execute();
$stmt->store_result();
//$result = $stmt->get_result();
$num_of_rows =$stmt->num_rows;

//$num_of_rows = $result->num_rows;
$stmt->close();

if ($num_of_rows > 0){
  header("Location: ../editteamnames.php?status=team_exists");
  exit();
}

// change the name of the team

$query = "UPDATE teams SET  team_name = ? WHERE team_name ='". $oldteam ."' AND league_id ='". $league ."';";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $newteam);
$stmt->execute();
$stmt->close();

header('Location: ../editteamnames.php?status=changed');
exit();
?>
