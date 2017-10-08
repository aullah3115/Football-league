<?php

//This is the number of teams
if (!isset($_POST['teams'])) {
	$teams = 2;
} else {
	$teams = (int)$_POST['teams'];
	
}

	$dummy = false;

// this stores the teams in an array 
if (!isset($_POST['teamName'])) {
	$teamList = array();
} else {
	$teamList = array();
	$teamList = $_POST['teamName'];
	if ($teams % 2 == 1){
	$dummy = true;
	}
	
	if($dummy==true) {
		array_push($teamList, "dummy");
		
	}
	
}

$totalRounds = $teams - 1;
if ($dummy == true) {
	$totalRounds = $teams;
}

$matchesPerRound = $teams / 2;

if ($dummy == true){
$matchesPerRound = ($teams + 1) / 2;
}

$fixtures = array();
//for ($i = 0; $i < $totalRounds; $i++) {
//	$fixtures[$i] = array();
//}
//
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
		
		$fixtures[$round][$game] = array($team1, $team2);
	}
}
