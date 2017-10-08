<?php
session_start();
include '../includes/connect.inc.php';
include '../includes/checklog.inc.php';
if (!isset($_POST)){
  header('Location ../addteams.php?status=unsubmitted');
  exit();
}
$league = (int)$_SESSION['league_id'];
$team = array_search('delete', $_POST);

//check to see if delete was clicked and delete team

if(isset($_POST[$team])){
$team = base64_decode($team);
$team = mysqli_real_escape_string($conn, $team);


$query = "DELETE FROM teams WHERE league_id ='" . $league . "' AND team_name ='". $team ."';";
$conn->query($query);

//count no of teams in league
$query = "SELECT COUNT(*) AS no_of_teams FROM teams WHERE league_id ='". $league ."';";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$no_of_teams = (int)$row['no_of_teams'];
$_SESSION['teamnum'] = $no_of_teams;

//set dummy team in teams table to true or false depending on num of teams

if($no_of_teams % 2 == 1) {
  $query = "UPDATE leagues SET league_dummy = 1 WHERE league_id ='". $league ."';";
  $conn->query($query);
} else {
  $query = "UPDATE leagues SET league_dummy=0 WHERE league_id ='". $league ."';";
  $conn->query($query);
}

$query = "SELECT * FROM leagues WHERE league_id ='". $league ."';";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$dummy=$row['league_dummy'];

$_SESSION['dummy']=$dummy;

//go back

header('Location: ../editteams.php?status=removed');
exit();
}

$oldteam = array_search('change', $_POST);
$oldteam = base64_decode($oldteam);


$query = "SELECT * FROM teams WHERE team_name ='".$oldteam."' AND league_id='".$league."';";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$id = $row['team_id'];

$newteam=$_POST[$id];
$ewteam = mysqli_real_escape_string($conn, $newteam);

$_SESSION['newteam'] = $newteam;
$_SESSION['oldteam'] = $oldteam;

if (empty($newteam)){
  header('Location: ../editteams.php?status=empty');
  exit();
}
$league = (int)$_SESSION['league_id'];
$query = "SELECT * FROM teams WHERE team_name = ? AND league_id ='" . $league . "';";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $newteam);
$stmt->execute();
$result = $stmt->get_result();


$num_of_rows = $result->num_rows;
$stmt->close();

if ($num_of_rows > 0){
  header("Location: ../editteams.php?status=team_exists");
  exit();
}
$query = "UPDATE teams SET  team_name = ? WHERE team_name ='". $oldteam ."' AND league_id ='". $league ."';";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $newteam);
$stmt->execute();
$stmt->close();



header('Location: ../editteams.php?status=changed');
exit();
?>

?>
