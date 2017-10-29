<?php
session_start();
include 'includes/connect.inc.php';
include 'includes/checklog.inc.php';

if(!isset($_POST)){
  header('Location: dashboard.php');
  exit();
}

$league = (int)$_SESSION['league_id'];
/*
$team = array_search('Add Players', $_POST);

if(isset($_POST[$team])){
$team = base64_decode($team);


$query = "SELECT * FROM teams WHERE team_name ='".$team."' AND league_id='".$league."';";
$result = $conn->query($query);
$row=$result->fetch_assoc();
$team_id = $row['team_id'];
$_SESSION['team_id']=$team_id;
}
*/

?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1><?php echo //$_SESSION['zz'];?></h1>
  <form method="post" action="leaguedashboard.php">
    <input type="submit" name="submit" value="Back to Teams">
  </form>
  <h1>Add/Remove Players</h1>
  <p>team name: <?php echo var_dump($_POST);//echo $team?></p>
  <p>team id: <?php echo $_SESSION['team_id']?></p>
  <h3>Add new player to this team</h3>
  <!-- add new player to database and put player in current team-->
  <form method="post" action="scripts/addplayer.s.php">
    <input type="text" name="first" placeholder="First Name"><br/>
    <input type="text" name="last" placeholder="Last Name"><br/>
    <input type="text" name="email" placeholder="E-mail address"><br/>
    <input type="text" name="phone" placeholder="Phone number"><br/>
    <input type="submit" name="addplayer" value="Add Player"><br/>
  </form>
<br/>

<h3>Add existing player</h3>
<form method="post" action="scripts/addplayer.s.php">
<select name="player">
      <?php
      $user = (int)$_SESSION['id'];
      $league = (int)$_SESSION['league_id'];
        $query = "SELECT * FROM players WHERE user_id =". $user ." AND players.player_id NOT IN
                  (SELECT P.player_id FROM players AS P
                  LEFT JOIN player_team AS PT ON P.player_id = PT.player_id
                  LEFT JOIN teams AS T ON t.team_id = PT.team_id
                  WHERE PT.team_id IS NOT NULL AND league_id = ". $league .");";
        $result = $conn->query($query);



        while($row = $result->fetch_assoc()){
          //echo var_dump($row);
          $pid = $row['player_id'];
          $name = $row['player_first'] . " " . $row['player_last'];
          echo '<option value=' . $pid . '>' . $name . '</option>';
        }

      ?>
  </select>
  <input type='submit' name='submit' value='Submit'>
</form>
<br/>
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

        echo '<input type="text" name="' . $row['player_id'] . '" placeholder="' . $player_first .' '.$player_last. '">';

      //  echo '<input type="submit" name="' . $encode_player_name . '" value="change">';
        echo '<input type="submit" name="' . $encode_player_name . '" value="delete"><br/>';
      }
    ?>
  </form>
  <br/>
<p><?php if(isset($_SESSION['pfn'])){echo $_SESSION['pfn'];}?></p>
<p><?php if(isset($_SESSION['pln'])){echo $_SESSION['pln'];}?></p>
<p><?php if(isset($_SESSION['pn'])){echo var_dump($_SESSION['pn']);}?></p>
</body>
</html>
