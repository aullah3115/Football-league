<?php
session_start();
include '../includes/connect.inc.php';
include '../includes/checklog.inc.php';

if (!isset($_POST)){
  header('Location ../dashboard.php');
  exit();
}

$team = (int)$_SESSION['team_id'];
$player = array_search('delete', $_POST);

if(isset($_POST[$player])){
$player = base64_decode($player);
$player_name = preg_split('/\s+/', $player);;
$first = $player_name[0];
$last = $player_name[1];

$query = "SELECT * FROM players WHERE player_first='" . $first . "' AND player_last='" . $last . "' AND user_id=" . $_SESSION['id'] . ";";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$player_id = $row['player_id'];

$_SESSION['pid'] = $player_id;
$_SESSION['pfn'] = $first;
$_SESSION['pln'] = $last;
$_SESSION['pn'] = $player_name;

$query = "DELETE FROM player_team WHERE team_id =" . $team . " AND player_id =". $player_id . ";";
$result = $conn->query($query);
$_SESSION['zz'] = $conn->error;
header('Location: ../addplayer.php?status=removed');
exit();
}

//

$oldplayer = array_search('change', $_POST);
$oldplayer = base64_decode($oldplayer);


$query = "SELECT * FROM teams WHERE CONCAT(player_first, ' ', player_last) AS player_name ='" . $oldplayer . "' AND team_id='".$team."';";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$id = $row['player_id'];

$newplayer=$_POST[$id];
$ewteam = mysqli_real_escape_string($conn, $newplayer);

$_SESSION['newplayer'] = $newplayer;
$_SESSION['oldplayer'] = $oldplayer;

if (empty($newplayer)){
  header('Location: ../addplayer.php?status=empty');
  exit();
}
$team = (int)$_SESSION['team_id'];
$query = "SELECT * FROM players WHERE _name = ? AND league_id ='" . $league . "';";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $newteam);
$stmt->execute();
//$result = $stmt->get_result();
$stmt->store_result();
$num_of_rows = $stmt->num_rows;
//$num_of_rows = $result->num_rows;
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
