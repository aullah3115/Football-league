<div class="team">
  <h3><?php echo $second;?></h3>
  <form method="post" action="scripts/addevent.s.php">
    <select name="event">
      <option selected></option>
        <?php
          $query ="SELECT * FROM events;";
          $result = $conn->query($query);
          while ($row = $result->fetch_assoc()){
          echo '<option value="'. $row['event_id'] .'">'. $row['event_name'] . '</option>';
          }
        ?>
  </select>
  <select name="player">
    <option selected></option>
      <?php
      /*
        $query ="SELECT P.player_id, P.player_first, P.player_last FROM player_team AS PT
        LEFT JOIN players AS P ON P.player_id = PT.player_id
        WHERE PT.team_id=". $team2_id .";";
        $result = $conn->query($query);
*/
        $result = playerDetails($conn, $team2_id);
        while ($row = $result->fetch_assoc()){
        echo '<option value="'. $row['player_id'] .'">'. $row['player_first'] . ' ' . $row['player_last'] . '</option>';
        }
      ?>
</select>
<input type="submit" name="submit" value="submit">
</form>
<hr/>
<form method="post" action="scripts/deleteevent.s.php">
  <?php
  /*
  $query = "SELECT ME.*, E.event_name, P.player_first, P.player_last FROM match_events AS ME
            LEFT JOIN players AS P ON ME.player_id = P.player_id
            LEFT JOIN player_team AS PT ON PT.player_id = P.player_id
            LEFT JOIN events AS E ON E.event_id = ME.event_id
            WHERE ME.match_id=". $match_id ." AND PT.team_id =". $team2_id .";";
  $result = $conn->query($query);
  */
  $result = matchEvents($conn, $match_id, $team2_id);

  while ($row=$result->fetch_assoc()){

    echo '<input type="text" name="'. $row['event_no'] .'" value="' . $row['player_first']. ' ' . $row['player_last'] . '" readonly="readonly">';
    echo  '<output>' . $row['event_name'] . '</output>';
    echo '<input type="submit" name="' . $row['event_no'] . '" value="delete"><br/>';
    //echo $row['player_first'] . " ";
    //echo $row['player_last'] . "<br/>";
  }
  ?>
</form>


</div>
