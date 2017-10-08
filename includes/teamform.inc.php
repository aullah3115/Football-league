<?php 
echo '<h1>Add Teams</h1>';
	if (isset($_POST['teams'])) {
	for($i = 0; $i < $teams; $i++){
		if(isset($teamList[$i]) && ($teamList[$i] !== "dummy")) {
			echo '<label>Team'. ($i + 1) . '</label>
			<input type="text" name="teamName[]" value="'. htmlspecialchars($teamList[$i]) .'"><br/>';
		} else {
			echo '<label>Team'. ($i + 1) . '</label>
			<input type="text" name="teamName[]" value=""><br/>';
			
		}
		
		}
	}
echo '<input type="Submit" value="Confirm">';
echo '<br/>';