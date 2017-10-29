<?php
session_start();
include 'includes/checklog.inc.php';
include 'includes/connect.inc.php';

if (!isset($_SESSION['league_id'])){
  header('Location: dashboard.php?status=' . $_SESSION['league_id']);
  exit();
}

// function which counts the number of a specific event for a specific team

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

// query which stores as an associative array a list of teams in the current league

$league_id = (int)$_SESSION['league_id'];
$query = "SELECT * FROM teams WHERE league_id='". $league_id ."';";
$result = $conn->query($query);
$teams = array();
while ($row = $result->fetch_assoc()){
  $teams[$row['team_id']] = $row['team_name'];
}

//  cycle through each team in the teams array

foreach ($teams as $key => $team) {

// initialize the following variables

  $points = 0;
  $wins = 0;
  $draws = 0;
  $losses = 0;
  $goals_for = 0;
  $goals_against = 0;

// find all matches in the matches table in which the selected team is team1

  $query = "SELECT * FROM matches WHERE status = 'played' AND team1_id =" . $key;
  $result = $conn->query($query);

// cycle through each of these matches

  while ($row = $result->fetch_assoc()){
    $match_id = $row['match_id'];
    $team1 = $row['team1_id'];
    $team2 = $row['team2_id'];

  // find the goals for of the selected team

  $team1_goals_scored = countEvent($conn, $match_id, 'goal', $team1);
  $team2_own_goals = countEvent($conn, $match_id, 'own goal', $team2);
  $team1_goals = $team1_goals_scored + $team2_own_goals;

  // find the goals for of the selected team's opponents

  $team2_goals_scored = countEvent($conn, $match_id, 'goal', $team2);
  $team1_own_goals = countEvent($conn, $match_id, 'own goal', $team1);
  $team2_goals = $team2_goals_scored + $team1_own_goals;

  // add the goals for and against to their respective variables

  $goals_for += $team1_goals;
  $goals_against += $team2_goals;

  //calculate points using the goals for and against

  if ($team1_goals > $team2_goals) {
    $points += 3;
    $wins++;
  } elseif ($team1_goals < $team2_goals) {
    $points += 0;
    $losses++;
  } else{
    $points += 1;
    $draws++;
  }

}

// find all games in which the current team is team2

$query = "SELECT * FROM matches WHERE status = 'played' AND team2_id =" . $key;
$result = $conn->query($query);

// cycle through selected matches

while ($row = $result->fetch_assoc()){
  $match_id = $row['match_id'];
  $team1 = $row['team1_id'];
  $team2 = $row['team2_id'];

// find goals for opponent

$team1_goals_scored = countEvent($conn, $match_id, 'goal', $team1);
$team2_own_goals = countEvent($conn, $match_id, 'own goal', $team2);
$team1_goals = $team1_goals_scored + $team2_own_goals;

// find goals for selected team

$team2_goals_scored = countEvent($conn, $match_id, 'goal', $team2);
$team1_own_goals = countEvent($conn, $match_id, 'own goal', $team1);
$team2_goals = $team2_goals_scored + $team1_own_goals;

// add goals for and against to respective variables

$goals_for += $team2_goals;
$goals_against += $team1_goals;

// calculate points
if ($team1_goals > $team2_goals) {
  $points += 0;
  $losses++;
} elseif ($team1_goals < $team2_goals) {
  $points += 3;
  $wins++;
} else{
  $points += 1;
  $draws++;
}

}

// store all data in an array for the selected team

$data[$team] = array("points" => $points,
                      "wins"  => $wins,
                      "draws" => $draws,
                      "losses"=> $losses,
                      "played"=> ($wins + $draws + $losses),
                      "gf"    => $goals_for,
                      "ga"    => $goals_against,
                      "gd"    => ($goals_for - $goals_against)
                    );

// sort the array based on points, then goal difference, the goals scored

foreach ($data as $key => $row) {
    $points1[$key]  = $row['points'];
    $gd[$key] = $row['gd'];
    $gf[$key] = $row['gf'];
}

array_multisort($points1, SORT_DESC, $gd, SORT_DESC, $gf, SORT_DESC, $data);

/*
array_multisort(array_column($data, 'points'),  SORT_DESC,
                array_column($data, 'gd'), SORT_DESC,
                array_column($data, 'gf'), SORT_DESC,
                $data);

$total_points[$team] = $points;
$total_wins[$team] = $wins;
$total_draws[$team] = $draws;
$total_losses[$team] = $losses;
$played[$team] = $wins + $draws + $losses;
$total_gf[$team] = $goals_for;
$total_ga[$team] = $goals_against;
$goal_diff[$team] = $goals_for - $goals_against;

arsort($total_points);
*/
}


?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <?php
//  echo var_dump($total_points) . '<hr/>';
//  echo var_dump($total_wins) . '<hr/>';
//  echo var_dump($total_draws) . '<hr/>';
//  echo var_dump($total_losses) . '<hr/>';
/*
foreach($data as $key1 => $team) {
  echo $key1 . "<br/>";
  foreach ($team as $key => $value) {
    echo $key . " " . $value . "<br/>";
  }
  echo "<hr/>";
}
*/
  ?>
  <h1>League Standings</h1>
  <hr/>
  <table>
    <th>  </th>
    <th>Team </th>
    <th>P</th>
    <th>W</th>
    <th>D</th>
    <th>L</th>
    <th>GF</th>
    <th>GA</th>
    <th>GD</th>
    <th>Points</th>
    <?php
    $index = 0;
    foreach ($data as $team => $stats) {
      echo '<tr>';
      echo '<td>' . ($index + 1) . '</td>';
      echo '<td>' . $team . '</td>';
      echo '<td>'. $stats['played'] .'</td>';
      echo '<td>'. $stats['wins'] .'</td>';
      echo '<td>'. $stats['draws'] .'</td>';
      echo '<td>'. $stats['losses'] .'</td>';
      echo '<td>'. $stats['gf'] .'</td>';
      echo '<td>'. $stats['ga'] .'</td>';
      echo '<td>'. $stats['gd'] .'</td>';
      echo '<td>'. $stats['points'].'</td>';
      echo '</tr>';
    }
      /*
    $array_length = count($total_points);


    for ($i = 0; $i < $array_length; $i++){

    }
*/

    ?>
  </table>
</body>
</html>
