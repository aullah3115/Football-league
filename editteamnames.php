<?php
session_start();
include 'includes/connect.inc.php';
include 'includes/checklog.inc.php';


$query1 = "SELECT COUNT(*) AS no_of_teams FROM teams WHERE league_id =" . $_SESSION['league_id'] . ";" ;
$result1 = $conn->query($query1);
$row1 = $result1->fetch_assoc();
$no_of_teams = $row1['no_of_teams'];
$_SESSION['no_of_teams'] = $no_of_teams;

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<h2>There are <?php echo $no_of_teams;?> teams in this league</h2>
<h3>Dummy team: <?php
if(isset($_SESSION['dummy']))
{echo $_SESSION['dummy'];}?></h3>
  <form method="post" action="includes/logout.inc.php">
    <input type=submit name="logout" value="Log out">
  </form><br/>




<form method=post action="scripts/editteamname.s.php">
<?php
$query = "SELECT * FROM teams WHERE league_id=" . $_SESSION['league_id'];
$result = $conn->query($query);
  while($row = $result->fetch_assoc()){
    $team = $row['team_name'];
    $encode_team = base64_encode($team);

    echo '<input type="text" name="'.$row['team_id'].'" placeholder="'. $team .'">';

    echo '<input type="submit" name="' . $encode_team . '" value="change"><br/>';
}
?>
</form>
<br/>
<form method="post" action="leaguedashboard.php">
  <input type=submit name="submit" value="Go Back">
</form>

<p><?php echo 'Logged in:' . $_SESSION['logged'];?></p>
<p><?php echo 'Team:' . var_dump($_SESSION);?></p>
<p><?php echo 'league id:' . $_SESSION['league_id'];?></p>
</body>
</html>
