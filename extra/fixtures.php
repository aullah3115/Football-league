<?php
	require('includes/fixtures.inc.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	<form method="post" >
		<fieldset>
		<h1>Select number of teams</h1>
		<label for="Teams">No of teams: </label>
		<input id ="teams"type='text' name="teams" value="<?php echo htmlspecialchars($teams); ?>">
		<input type="Submit" value="Set"><br/><br/>
		</fieldset>

		<fieldset id="dynamic">



		<!-- This dynamically generates a form for team entry -->
		<?php

		require('includes/teamform.inc.php');

		?>
		</fieldset>
	</form><br/>

	<?php
	//generate fixture list
	require('includes/fixturelist.inc.php');
	?>

	<?php
	echo '<div id="teams">';
	echo '<h1>Teams</h1><ul>';

	foreach ($teamList as $team) {
		if($team != "dummy") {
		echo '<li>'. $team . '</li>';
		}
	}
	echo '</ul></div>';

	?>

</body>
</html>
