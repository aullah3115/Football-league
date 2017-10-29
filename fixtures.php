<?php

session_start();
include 'includes/checklog.inc.php';
include 'includes/connect.inc.php';

function countEvent ($conn, $match, $event, $team) {

  $query = 'SELECT COUNT(*) AS num FROM match_events AS me
LEFT JOIN player_team AS pt ON pt.player_id = me.player_id
LEFT JOIN players AS p ON p.player_id = me.player_id
LEFT JOIN events AS e ON e.event_id = me.event_id
WHERE me.match_id = '. $match .' AND e.event_name ="'. $event .'"  AND pt.team_id = '. $team .';';
$result = $conn->query($query);
$row = $result->fetch_assoc();
$num = $row['num'];

return $num;

}

$league_id = $_SESSION['league_id'];

$query = "SELECT * FROM leagues WHERE league_id = " . $league_id . ";";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$num_weeks = $row['league_weeks'];

$sql = "SELECT COUNT(*) AS num_teams FROM teams WHERE league_id ='".$league_id."';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$num_teams = $row['num_teams'];
$_SESSION['teamnum']= $num_teams;
if ($num_teams%2==1){
  $matchesPerRound=($num_teams - 1)/2;
}else{
  $matchesPerRound=($num_teams)/2;
}

if(!isset($_POST['week'])){
  $week=1;
} else {
  $week = (int)$_POST['week'];
}

$query = "SELECT matches.status, matches.team1_id, matches.team2_id, FT.team_name AS first, matches.match_id, matches.week_no, matches.round_no, ST.team_name AS second
FROM matches
LEFT JOIN teams AS FT ON matches.team1_id = FT.team_id
LEFT JOIN teams AS ST ON matches.team2_id = ST.team_id
WHERE FT.league_id = ". $league_id ." AND matches.team1_id = FT.team_id
AND matches.week_no = ". $week ."
ORDER BY matches.match_id;" ;

//

$result = $conn->query($query);



?>
<!DOCTYPE html>
<html>
<head>
  <title>Fixtures</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <form action="leaguedashboard.php" method="post">
    <input type="submit" name="submit" value="Go back">
  </form><br/>
<form method="post" >
  <select name='week'>
<?php
for($i = 0; $i < $num_weeks; $i++){
  echo '<option value=' . ($i + 1) . '>Week '. ($i + 1) . '</option>';
}
?>
</select>

<input type='submit' name='submit'value='select'>
</form>

<?php
echo '<h1>WEEK '. $week . '</h1><br/>';
?>
<form method="post" action="scripts/openmatch.s.php">
<?php
$i=0;
$j=1;
while($row=$result->fetch_assoc()){
if ($i==$matchesPerRound){
  $i=0;
}
if($i==0){
  echo '<h4>Round ' . $j . '</h4>';
  $j++;
}
  //$query = "SELECT COUNT(*) FROM match_events WHERE ma"
  $team1 = $row['team1_id'];
  $team2 = $row['team2_id'];
  $match_id = $row['match_id'];
  $first = $row['first'];
  $second = $row['second'];
  $status = $row['status'];
  echo '<label class="fixture">'. $first . ' vs ' . $second . '</label>';
  $team1_goals_scored = countEvent($conn, $match_id, 'goal', $team1);
  $team2_own_goals = countEvent($conn, $match_id, 'own goal', $team2);
  $team1_goals = $team1_goals_scored + $team2_own_goals;
  echo $team1_goals;
  echo ' - ';
  $team2_goals_scored = countEvent($conn, $match_id, 'goal', $team2);
  $team1_own_goals = countEvent($conn, $match_id, 'own goal', $team1);
  $team2_goals = $team2_goals_scored + $team1_own_goals;
  echo $team2_goals;
  echo '<input type="submit" value="Select" name="'.$match_id.'">'. $status .'<br/>';
  $i++;
}
?>
</form>

</body>
</html>
