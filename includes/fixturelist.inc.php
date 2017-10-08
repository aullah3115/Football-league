<?php
//This generates fixtures automatically
echo '<div id="fixtures"><h1>Fixtures List</h1>';
	for($i = 0; $i < $totalRounds; $i++) {
		echo '<h2>Round '. ($i + 1) . '</h2>';
		echo '<ul>';
		for ($j = 0; $j < $matchesPerRound; $j++) {
			$match = $fixtures[$i][$j];
			if (isset($match)){
				
				if((isset($teamList[$match[0]]) && $teamList[$match[0]] == "dummy") 
					|| (isset($teamList[$match[1]]) && $teamList[$match[1]] == "dummy") ) {
					} else {
					if (isset($teamList[$match[0]])){
					 echo '<li>'. $teamList[$match[0]];
					} else {echo '<li>';}
					echo " vs ";
					if(isset($teamList[$match[1]])){
						echo $teamList[$match[1]] . '</li>' ;
					} 
					
				}
				
			}
		}
		echo '</ul>';
	}
	echo '</div>';