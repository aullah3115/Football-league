<?php
session_start();
include 'includes/connect.inc.php';
include 'includes/checklog.inc.php';

if (!isset($_POST)){
  header('Location: leaguedashboard.php');
}

//$match_id = array_search('Select', $_POST);

//$_SESSION['match_id'] = $match_id;

// functions for this page

function playerDetails($conn, $team_id) {
  $query ="SELECT P.player_id, P.player_first, P.player_last FROM player_team AS PT
  LEFT JOIN players AS P ON P.player_id = PT.player_id
  WHERE PT.team_id=". $team_id .";";
  return $conn->query($query);
}

function matchEvents($conn, $match_id, $team_id){
  $query = "SELECT ME.*, E.event_name, P.player_first, P.player_last FROM match_events AS ME
            LEFT JOIN players AS P ON ME.player_id = P.player_id
            LEFT JOIN player_team AS PT ON PT.player_id = P.player_id
            LEFT JOIN events AS E ON E.event_id = ME.event_id
            WHERE ME.match_id=". $match_id ." AND PT.team_id =". $team_id .";";
  return $conn->query($query);
}

$match_id=$_SESSION['match_id'];

// get match details

$query = "SELECT M.*, FT.team_name AS first, ST.team_name AS second
FROM matches AS M
LEFT JOIN teams AS FT ON M.team1_id = FT.team_id
LEFT JOIN teams AS ST ON M.team2_id = ST.team_id
WHERE M.match_id =". $_SESSION['match_id'];

$result = $conn->query($query);
//$error = $conn->error;
$row = $result->fetch_assoc();
$first = $row['first'];
$second = $row['second'];
$team1_id = (int)$row['team1_id'];
$team2_id = (int)$row['team2_id'];
$match_status = $row['status'];


?>

<!DOCTYPE html>
<html>
<head>
  <title>Match</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <form action="fixtures.php" method="post">
    <input type="submit" name="submit" value="Go back to fixtures">
  </form><br/>
  <form method="post" action="scripts/confirmscore.s.php">
    <input type="submit" name="confirm" value="Confirm result">
  </form><br/>
  <p><?php echo $match_status;?></p>
  <hr/>
  <?php //echo $_SESSION['error1']; ?>
<div class="container">

  <!-- Team 1 -->
  <?php
include 'includes/match_team1.inc.php';
include 'includes/match_team2.inc.php';
  ?>
  <!-- team 2 -->

</div>
<hr/>


  <?php
  //echo $error;
//  echo var_dump($row);
  ?>
</body>
</html>
