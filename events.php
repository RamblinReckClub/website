<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";

    $month=isset($_POST['dateMonth']) ? $_POST['dateMonth'] : '';
    //$month=$_POST['dateMonth'];
    if($month=='' || !isset($month)){
        $month=date('m');
    }
    if($month=='01'){$monthName='January';}
    if($month=='02'){$monthName='February';}
    if($month=='03'){$monthName='March';}
    if($month=='04'){$monthName='April';}
    if($month=='05'){$monthName='May';}
    if($month=='06'){$monthName='June';}
    if($month=='07'){$monthName='July';}
    if($month=='08'){$monthName='August';}
    if($month=='09'){$monthName='September';}
    if($month=='10'){$monthName='October';}
    if($month=='11'){$monthName='November';}
    if($month=='12'){$monthName='December';}

if($month=='all') {
	$pageTitle =  "All Events";
} else {
	$pageTitle =  $monthName." Events";
}

?>
<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>
<div class="container">
	<?php

    // CREATE FORM FOR UPDATING USER'S POINTS
    //---------------------------------------------------------

    echo "<div class=\"row\">
        <div class=\"col-12\">";
    echo "<h2 class=\"float-left\">Events</h2>";
    if($month=='all') {
        $query = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '0' ORDER BY dateYear, dateMonth, dateDay, eventName");
        $query->setFetchMode(PDO::FETCH_ASSOC);
    } else {
        $query = $db->prepare("SELECT * FROM Event WHERE isFamilyEvent = '0' AND dateMonth = :month ORDER BY dateYear, dateMonth, dateDay, eventName");
        $query->execute(array('month'=>$month));
        $query->setFetchMode(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="float-right">
        <form id="monthSelect" action="/events.php" method="post">
            <select name="dateMonth" class="form-control custom-select" onchange="this.form.submit()">
                <option value="01" <?PHP if($month=='01') echo "selected";?>>January</option>
                <option value="02" <?PHP if($month=='02') echo "selected";?>>February</option>
                <option value="03" <?PHP if($month=='03') echo "selected";?>>March</option>
                <option value="04" <?PHP if($month=='04') echo "selected";?>>April</option>
                <option value="05" <?PHP if($month=='05') echo "selected";?>>May</option>
                <option value="06" <?PHP if($month=='06') echo "selected";?>>June</option>
                <option value="07" <?PHP if($month=='07') echo "selected";?>>July</option>
                <option value="08" <?PHP if($month=='08') echo "selected";?>>August</option>
                <option value="09" <?PHP if($month=='09') echo "selected";?>>September</option>
                <option value="10" <?PHP if($month=='10') echo "selected";?>>October</option>
                <option value="11" <?PHP if($month=='11') echo "selected";?>>November</option>
                <option value="12" <?PHP if($month=='12') echo "selected";?>>December</option>
                <option value="all" <?PHP if($month=='all') echo "selected";?>>All Events</option>
            </select>
        </form>
    </div>
    <form id="updatePoints" name="updatePoints" action="/updatePoints.php" method="POST">
    <?php
    if ($query->rowCount() == 0) {
        echo "</div></div><div class=\"row\">
        <div class=\"col-12\">";
        if($month=='all'){
            echo "<p>There are currently no events recorded.</p>";
        } else {
            echo "<p>There are currently no events recorded for the month of ".$monthName.".</p>";
        }
    } else {
        echo "<table class='table table-hover table-sm mb-3'><thead>
                <tr>
                    <th scope=\"col\"></th>
                    <th scope=\"col\">Date</th>
                    <th scope=\"col\">Name</th>
                    <th scope=\"col\" style=\"text-align:right !important;\">Points</th>
                </tr>
                </thead>
                <tbody>";
        $count = 0;
        while($row = $query->fetch())  {
//			$counter = $counter + 1;
            $tempEventID = $row['eventID'];
            $attends_query = $db->query("SELECT * FROM AttendsEvent WHERE eventID = $tempEventID AND memberID = $memberID");
            $attends_query->setFetchMode(PDO::FETCH_ASSOC);
            $num_results3 = $attends_query->rowCount();
            echo "<tr id=\"event-" . $row['eventID'] ."\">";
            echo "<th scope='row'><input id=\"event".$count."\" class='event-checkbox' type=\"checkbox\" name=\"";
            echo $row['eventID'];
            echo "\" ";
            if($num_results3 == 1) {
                echo " CHECKED";
            } else { }
            echo "></th><label for=\"event".$count."\"></label>";
            echo "<td>".$row['dateMonth']."-".$row['dateDay']."</td><td><a href='/event.php?id=". $row['eventID']."'>".$row['eventName'] . "</a>";
            if($row['isBonus'] == 1) {
                echo " <span class=\"text-muted\">(BONUS)</span>";
            } else { }
            $typeClass = '';
            if ($row['type'] == 'mandatory') {
                $typeClass = 'event-type-mandatory';
            } else if ($row['type'] == 'sports') {
                $typeClass = 'event-type-sports';
            } else if ($row['type'] == 'social') {
                $typeClass = 'event-type-social';
            } else if ($row['type'] == 'work') {
                $typeClass = 'event-type-work';
            } else {
                $typeClass = '';
            }
            echo " <span class=\"badge badge-primary " . $typeClass ."\">" . $row['type'] ."</span></td>";
            echo "</div><td align='right'>".$row['pointValue']."</td></tr>";
            $count++;
            echo "<input type=\"hidden\" name=\"query_bound\" value=\"recent\">";
        }
        echo "</tbody></table></div></div>";
        echo "<div class=\"row mb-3\">
        <div class=\"col-12\">
            <div class=\"float-right\">
                <input type=\"submit\" class=\"btn btn-primary\" id=\"submit-points-button\" form='updatePoints' value='Update'>
            </div>
        </div>
    </div>";
    }

    if($month=='all') {
        echo "<input type=\"hidden\" name=\"query_bound\" value=\"all\">";
    } else {
        echo "<input type=\"hidden\" name=\"query_bound\" value=\"".$month."\">";
    }
    echo "</form>";
?>
</div>
<div class="container">
    <?php require "eventAdminContainer.php" ?>
</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
</body>

</html>