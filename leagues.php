<?php
session_start();
include 'includes/checklog.inc.php';
include 'includes/connect.inc.php';

 ?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1>My Leagues</h1>
  <form method="post" action="includes/logout.inc.php">
    <input type=submit name="logout" value="Log out">
  </form>

  <?php
/*
foreach($_SESSION as $k => $v){
  echo '<p>'. $k . ": " . $v . '</p>';
}
*/
?>

<form method="post" action="dashboard.php">
  <input type=submit name="submit" value="Go Back">
</form><br/>

<form method="post" action="scripts/openleague.s.php">
<label class="heading">League Name</label><br/>
<?php
$id = (int)$_SESSION['id'];
$query = "SELECT * FROM leagues WHERE user_id =". $id;
$result = $conn->query($query);

while($row = $result->fetch_assoc()) {
  echo '<label>' . $row['league_name'] . '</label>';
  $encode_league = base64_encode($row['league_name']);
  echo '<input type="submit" name="' . $encode_league . '" value="Select">';
  echo '<input type="submit" name="' . $encode_league . '" value="Delete"><br/>';
}
?>
</form>

</body>
</html>
