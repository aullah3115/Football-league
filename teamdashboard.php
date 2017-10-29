<?php
session_start();
include 'includes/checklog.inc.php';
include 'includes/connect.inc.php';

if(!isset($_POST)){
  header('Location: dashboard.php');
  exit();
}
$league = (int)$_SESSION['league_id'];
$team = array_search('View Team', $_POST);

if(isset($_POST[$team])){
$team = base64_decode($team);

$query = "SELECT * FROM teams WHERE team_name ='".$team."' AND league_id='".$league."';";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$team_id = $row['team_id'];
$_SESSION['team_id']=$team_id;
$_SESSION['team_name'] = $row['team_name'];
}

$query = "SELECT * FROM player_team AS PT
LEFT JOIN players AS P ON PT.player_id = P.player_id
WHERE PT.team_id='". $_SESSION['team_id'] ."';";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Teams</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
$query1 = "SELECT COUNT(*) AS num FROM match_events AS me
LEFT JOIN player_team AS pt ON pt.player_id = me.player_id
LEFT JOIN players as p ON p.player_id = me.player_id
LEFT JOIN events AS e ON e.event_id = me.event_id
WHERE me.match_id = 3539 AND e.event_name = 'goal' AND pt.team_id = 123;";

$result1 = $conn->query($query1);
$row = $result1->fetch_assoc();
$num = $row['num'];
echo $num;
?>
<h1><?php echo $_SESSION['team_name'];?></h1>

<form method="post" action="leaguedashboard.php">
  <input type="submit" name="submit" value="Go Back">
</form>

  <form method="post" action="addplayer.php">
    <input type="submit" name="submit" value="Add/Remove Players">
  </form>

  <form method="post" action="scripts/deleteplayer.s.php">

    <?php
    //select all players belonging to this team
    $query = "SELECT PT.player_id, PT.team_id, players.player_first, players.player_last FROM player_team AS PT
    LEFT JOIN players ON PT.player_id = players.player_id
    WHERE PT.team_id =". $_SESSION['team_id'];
    $result = $conn->query($query);

    //display players selected
      while($row = $result->fetch_assoc()){
        $player_first=$row['player_first'];
        $player_last=$row['player_last'];
        $player_name = $player_first. ' ' . $player_last;
        $encode_player_name = base64_encode($player_name);
        $encode_player_first = base64_encode($player_first);
        $encode_player_last = base64_encode($player_last);

        echo '<input type="text" readonly="readonly" name="' . $row['player_id'] . '" placeholder="' . $player_first .' '.$player_last. '">';

      //  echo '<input type="submit" name="' . $encode_player_name . '" value="change">';
        echo '<input type="submit" name="' . $encode_player_name . '" value="delete"><br/>';
      }
    ?>
  </form>

  <?php
  /*
while ($row=$result->fetch_assoc()) {
  echo $row['player_first'] . " " . $row['player_last'] . "<br/>";
}
*/
  ?>
</body>
</html>
