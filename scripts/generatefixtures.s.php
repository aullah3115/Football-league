<?php
session_start();

include '../includes/checklog.inc.php';
include '../includes/connect.inc.php';

if(!isset($_POST['submit'])) {
  header('Location: ../dashboard.php?error');
  exit();
}
//find out number of teams in league

if (!isset($_SESSION['league_id'])){
  header('Location: ../dashboard.php?status=league_not_selected');
  exit();
}
$no_of_teams = (int)$_SESSION['no_of_teams'];
$league_id = $_SESSION['league_id'];

$query = "UPDATE teams SET status='' WHERE status='added' AND league_id =". $_SESSION['league_id'] .";";
$conn->query($query);

$query = "DELETE FROM teams where status='deleted' AND league_id =". $_SESSION['league_id'] . ";";
$conn->query($query);


$query = "DELETE FROM matches WHERE EXISTS (SELECT * FROM teams WHERE teams.league_id = ".$league_id." AND matches.team1_id = teams.team_id)";
$result4 = $conn->query($query);

if ($no_of_teams % 2 == 0){
  $totalRounds = $no_of_teams - 1;
  $matchesPerRound = $no_of_teams / 2;
} else {
  $totalRounds = $no_of_teams;
  $matchesPerRound = ($no_of_teams + 1) / 2;
}

$query = "SELECT * FROM leagues WHERE league_id='". $league_id ."';";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$dummy = $row['league_dummy'];
$weeks = (int)$row['league_weeks'];
$rounds =(int)$row['league_rounds'];

// get team ids and store in array
$teamList = array();

$query = "SELECT team_id FROM teams WHERE league_id = '". $league_id ."';";
$result = $conn->query($query);

while($row = $result->fetch_assoc()){
  $teamList[] = $row['team_id'];
}

if($dummy==1){
  $teamList[] = "dummy";
}




//generate fixtures

for ($y = 0; $y < $weeks; $y++){

  for($x = 0; $x < $rounds; $x++){

    for ($round = 0; $round < $totalRounds; $round++) {

	     for ($game = 0; $game < $matchesPerRound; $game++) {
		       $team1 = ($game - $round);
		        if ($team1 < 1) {
			           $team1 = ($totalRounds + $team1);
		        }

		        $team2 = $totalRounds - ($round + $game);
		          if ($team2 < 1) {
			             $team2 = ($totalRounds + $team2);
		          }

		            if ($game == 0) {
			               $team1 = 0;
		            }


                if($teamList[$team1] == 'dummy' || $teamList[$team2] == 'dummy' ) {
                  continue;
                } else {

                  $query = "INSERT INTO matches (team1_id, team2_id, week_no, round_no)
                  VALUES ('". $teamList[$team1] ."', '". $teamList[$team2] ."', '". ($y+1) ."', '". ($x+1) ."');";

                  $conn->query($query);
                }

	             }
             }
           }
}



header('Location: ../leaguedashboard.php');
exit();

?>
