<?php
	require "logged_in_check.php";
	require "database_connect.php";
	require "set_session_vars_short.php";
	require "html_header_begin.txt";
?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php require "html_header_end.txt"; ?>

<h3>All Attended Events</h3>

<div align="center">
<a href="rankings.php">Back to Individual Rankings</a><br/><br/>
<a href="/friends.php?memberId=<?php echo $_POST['memberID']; ?>">Friends List</a><br/><br/>
<a href="/memberProfile.php?memberId=<?php echo $_POST['memberID']; ?>">View Profile</a>
</div><br/>

<?php
	// SHOW SELECTED USER'S NAME
	//-------------------------------------------

	$currentMemID = $_POST['memberID'];

   	$query = $db->prepare("SELECT firstName, lastName, memberPoints, status FROM Member WHERE memberID=:currentMemID");
	$query->execute(array('currentMemID'=>$currentMemID));
		$query->setFetchMode(PDO::FETCH_ASSOC);

	$row = $query->fetch();
	$currentFirstName = $row['firstName'];
	$currentLastName = $row['lastName'];
	$currentMemberPoints = $row['memberPoints'];
	$currentMemberStatus = $row['status'];

	// Total number of events
	//-------------------------------------------
	$query = $db->query("SELECT COUNT(*) as CNT FROM Event WHERE ( (MONTH(CURDATE()) BETWEEN 1 AND 7 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7) OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12) )");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$totalEvents = $row['CNT'];

	// Total number of events
	//-------------------------------------------
	$query = $db->query("SELECT STDDEV(memberPoints) as STD, AVG(memberPoints) as AVRG FROM Member WHERE status IN ('probate', 'member')");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$pointAVG = number_format($row['AVRG'],2);
	$pointSTD = number_format($row['STD'],2);

	// Probate Average
	//-------------------------------------------
	$query = $db->query("SELECT AVG(memberPoints) as AVRG FROM Member WHERE status = 'probate'");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$probateAVG = number_format($row['AVRG'],2);

	// Member Average
	//-------------------------------------------
	$query = $db->query("SELECT AVG(memberPoints) as AVRG FROM Member WHERE status = 'member'");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$memberAVG = number_format($row['AVRG'],2);

	// SHOW ALL ATTENDED EVENTS FOR THE SELECTED USER
	//-----------------------------------------------

	// CALCULATE MEMBER'S TOTAL POINTS
	//-----------------------------------------------

   	$query = $db->prepare("
        SELECT type FROM AttendsEvent 
            JOIN Event ON AttendsEvent.eventID = Event.eventID 
            WHERE memberID = :currentMemID
            AND (
                    (MONTH(CURDATE()) BETWEEN 1 AND 7  AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7)
                 OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12)
            )
            ");
	$query->execute(array('currentMemID'=>$currentMemID));
		$query->setFetchMode(PDO::FETCH_ASSOC);

	$mandatory=0;
	$sports=0;
	$social=0;
	$work=0;
	$events=0;

	while($row = $query->fetch()) {
		$events++;
		if($row['type']=='mandatory'){
			$mandatory++;
		}
		else if($row['type']=='sports'){
			$sports++;
		}
		else if($row['type']=='social'){
			$social++;
		}
		else if($row['type']=='work'){
			$work++;
		}
	}

	$eventPct = number_format(($events/$totalEvents)*100,1);

    $query = $db->query("SELECT COUNT(*) as CNT FROM Event where type = 'mandatory' AND ( (MONTH(CURDATE()) BETWEEN 1 AND 7 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7) OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12) )");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $row = $query->fetch();
    $mandatoryEvents = $row['CNT'];
?>
	<script type="text/javascript">
      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart','annotationchart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawCharts);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
	  function drawCharts(){
		drawChart();
		drawChart2();
	  }
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
		  ['Work', <?php echo($work) ?>],
          ['Social', <?php echo($social) ?>],
		  ['Sports', <?php echo($sports)?>],
          ['Mandatory', <?php echo($mandatory) ?>]


        ]);

        // Set chart options
        var options = {'height':200,chartArea:{left:"25%",top:"10",width:"100%",height:"90%"},legend:{position: 'right', textStyle: {color: 'black', fontSize: 11}},'is3D':false,pieSliceTextStyle:{color: 'black'}, backgroundColor:'#FFFFFF',colors:['#149F3D','#005ACE','#FFCB00','#D0D0D0']};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

	  function drawChart2() {
		  var data = new google.visualization.DataTable();
		  data.addColumn('date', 'Date');
		  data.addColumn('number', 'Point Value');
		  data.addRows([

		  <?php
			$pointValue=0;
			$dateMonth=0;
			$dateDay=0;
			$query2 = $db->prepare("SELECT eventName, dateYear, dateMonth, dateDay, pointValue FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE memberID = :currentMemID AND ( (MONTH(CURDATE()) BETWEEN 1 AND 7 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7) OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12) ) ORDER BY Event.dateMonth, Event.dateDay");
			$query2->execute(array('currentMemID'=>$currentMemID));
			$query2->setFetchMode(PDO::FETCH_ASSOC);

			while($row = $query2->fetch())
			{
				if($dateDay!=$row['dateDay'] || $dateMonth!=$row['dateMonth']){
				    $dateYear=$row['dateYear'];
					$dateMonth=$row['dateMonth'];
					$dateDay=$row['dateDay'];
					$pointValue+=$row['pointValue'];
					echo "[new Date(" . $dateYear .", ".($row['dateMonth']-1).", ".$row['dateDay']."), ".$pointValue."],";
				}
				else{
					$pointValue+=$row['pointValue'];
				}

			}
		  ?>

		  ]);

		  var annotatedtimeline = new google.visualization.AnnotationChart(
			  document.getElementById('chart2_div'));
		  annotatedtimeline.draw(data, {'displayAnnotations': false, height:500,'displayZoomButtons':false,displayRangeSelector:false,'colors':['#b3a369']});
		}

	</script>

    <div id="chart2_div" style="height:500px;width:600px;margin:0 auto;margin-bottom: 50px;"></div>

    <table align="center">
        <td colspan="5">
            <div id="chart_div" style="height:200px;margin-bottom: 25px;"></div>
        </td>
    <tr bgcolor="#b3a369"><th colspan="5"><?php echo($currentFirstName) ?> <?php echo($currentLastName) ?></th></tr>
    <tr><td colspan="1">Total Points:</td><td colspan="3"><?php echo($currentMemberPoints) ?></td></tr>
    <tr><td colspan="1">Probate Points Average:</td><td colspan="3"><?php echo($probateAVG) ?></td></tr>
    <tr><td colspan="1">Member Points Average:</td><td colspan="3"><?php echo($memberAVG) ?></td></tr>
    <tr><td colspan="1">RRC Points Average (Member + Probates):</td><td colspan="3"><?php echo($pointAVG) ?></td></tr>
    <!--<tr><td colspan="1">RRC Points Standard Deviation :</td><td colspan="3"><?php echo($pointSTD) ?></td></tr>-->
    <tr bgcolor="#b3a369"><th colspan="5">Events</th></tr>
    <tr bgcolor="#D0D0D0"><td colspan="1">Mandatory Events:</td><td colspan="3"><?php echo($mandatory) ?></td></tr>
    <tr bgcolor="#FFCB00"><td colspan="1">Sports Events:</td><td colspan="3"><?php echo($sports) ?></td></tr>
    <tr bgcolor="#005ACE"><td colspan="1">Social Events:</td><td colspan="3"><?php echo($social) ?></td></tr>
    <tr bgcolor="#149F3D"><td colspan="1">Work Events:</td><td colspan="3"><?php echo($work) ?></td></tr>
    <tr><td colspan="1">Total Events:</td><td colspan="2"><?php echo($events) ?> / <?php echo ($totalEvents) ?>  (<?php echo($eventPct)?>%)</td></tr>
        <?php
            if (($isAdmin || $isSecretary || $isTreasurer || $isVP) || $currentMemID == $memberID) {
                if ($currentMemberStatus == 'member' || $currentMemberStatus == 'probate') {
                    echo '<tr>';
                    echo '<td colspan="1">';
                    echo 'Events minimum met?';
                    echo '</td>';
                    echo '<td colspan="3">';
                    echo  (($events - $mandatory) >= 20) ? "Yes" : "<b>No</b>";
                    echo  "</td></tr>";

                    echo '<tr>';
                    echo '<td colspan="1">';
                    echo 'Mandatory events missed:';
                    echo '</td>';
                    echo '<td colspan="3">';
                    $diff = $mandatoryEvents - $mandatory;
                    echo ($diff < 3) ? $diff : "<b>".$diff."</b>";
                    echo  "</td></tr>";
                }
            }
        ?>
<?php
	echo "<tr bgcolor=\"#b3a369\"><th colspan=\"3\">Events Attended</th></tr>";
	echo "<tr><th width=350>Event</th><th width=100>Date</th><th>Points</th></tr>\n";

   	$query2 = $db->prepare("SELECT eventName, dateYear, dateMonth, dateDay, pointValue FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE memberID = :currentMemID AND ( (MONTH(CURDATE()) BETWEEN 1 AND 7 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7) OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12) ) ORDER BY Event.dateMonth, Event.dateDay");
	$query2->execute(array('currentMemID'=>$currentMemID));
		$query2->setFetchMode(PDO::FETCH_ASSOC);

	while($row = $query2->fetch())
		{
		echo "<tr><td>".$row['eventName']."</td><td>".$row['dateMonth']."-".$row['dateDay']."-".$row['dateYear']."</td><td>".$row['pointValue']."</td></tr>";
		}
?>
    </table>
<br/><br/><br/><br/>

<?php require "html_footer.txt"; ?>