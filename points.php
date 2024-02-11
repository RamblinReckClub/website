<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	$pageTitle = "Points";
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>
<?php
$eventCount = $mandatoryEventCount + $sportsEventCount + $socialEventCount + $workEventCount;

//CALCULATE RANK
//--------------

$rank_query = $db->query("SELECT memberID, memberPoints FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName");
$rank_query->setFetchMode(PDO::FETCH_ASSOC);

$count1 = 0;

while($row = $rank_query->fetch()) {
    $count1++;
    if($row['memberID'] == $memberID) {
        $rank = $count1;
        $pts = $row['memberPoints'];
    }
}

// SHOW USER'S TOTAL POINTS AND RANK
//----------------------------------

?>
<div class="container">
    <div class="mb-3" style="background: #b3a369; border-radius: 5px; border-color: #B3A369;">
        <div class="row p-4">
            <div class="col-lg-4">

                <h1 class="text-center display-1 mb-0 text-light">
                    <?php echo($pts); ?>
                </h1>
                <h5 class="text-center" style="color:#E6E7E8;">TOTAL POINTS</h5>
            </div>
            <div class="col-lg-4">
                <h1 class="text-center display-1 mb-0 text-light"><?php echo($rank); ?></h1>
                <h5 class="text-center" style="color:#E6E7E8;">RANK</h5>
            </div>
            <div class="col-lg-4">
                <h1 class="text-center display-1 mb-0 text-light"><?php echo($eventCount); ?></h1>
                <h5 class="text-center" style="color:#E6E7E8;">EVENTS</h5>
            </div>
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="row mb-3">
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <h2 class="col-12 float-left">Top 5</h2>
            </div>
            <ul class="list-group">
                <?php

                    $count = 1;

                    $top5_query = $db->query("SELECT memberID, firstName, lastName, memberPoints FROM Member WHERE status!='alumni' ORDER BY memberPoints DESC, lastName LIMIT 5");
                    $top5_query->setFetchMode(PDO::FETCH_ASSOC);

                    while($row = $top5_query->fetch()){
                        if ($row['memberID'] != $memberID) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>". $count . ". " . $row['firstName']." ".$row['lastName']." <span class=\"badge badge-primary badge-pill\">".$row['memberPoints']."</span></li>";
                        } else {
                            echo "<li class='list-group-item active d-flex justify-content-between align-items-center'>". $count . ". " . $row['firstName']." ".$row['lastName']." <span class=\"badge badge-light badge-pill\" style='color:#b3a369;'>".$row['memberPoints']."</span></li>";
                        }
                        $count++;
                    }

                ?>

            </ul>
            <div class="row mt-2"><a class="col-12 text-center" href="rankings.php">Complete Rankings</a></div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <h2 class="col-12 float-left">Families</h2>
            </div>
            <ul class="list-group">
                <?php
                $family_query = $db->query("SELECT familyName, familyPoints FROM Family ORDER BY familyPoints DESC, familyName");
                $family_query->setFetchMode(PDO::FETCH_ASSOC);

                $var = 1;

                while($row = $family_query->fetch()){
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>". $var . ". " . $row['familyName']. " <span class=\"badge badge-primary badge-pill\">".$row['familyPoints']."</span></li>";
                    $var++;
                }
                ?>
            </ul>
            <div class="row mt-2"><a class="col-12 text-center" href="families.php">Family Rankings</a></div>
        </div>
    </div>
    <form action="updatePoints.php" method="POST">
    <div class="row">
        <div class="col-12">
            <h2 class="float-left">Recent Events</h2>
            <table class="table table-hover mb-3">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Date</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="text-align:right !important;">Points</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $today = getdate();
                $currentday = $today['mday'];
                $currentmonth = $today['mon'];
                $currentyear = $today['year'];

                $events_query = $db->query("SELECT * FROM Event WHERE isFamilyEvent = '0' AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear ),'%m/%d/%Y') <= STR_TO_DATE(CONCAT($currentmonth,'/',$currentday,'/',$currentyear ),'%m/%d/%Y') ORDER BY dateYear DESC, dateMonth DESC, dateDay DESC, eventName LIMIT 0, 10");
                $events_query->setFetchMode(PDO::FETCH_ASSOC);

                $rowcount = $events_query->rowCount();
                $count = 1;

                if($rowcount==0){
                    echo "There are currently no events.";
                } else {
                    while($row = $events_query->fetch()){
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
                    }
                    echo "<input type=\"hidden\" name=\"query_bound\" value=\"recent\">";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="float-right">
                <a href="/events.php" class="btn btn-outline-secondary mr-2">View All Events</a>
                <input type="submit" class="btn btn-primary" id="submit-points-button">
            </div>
        </div>
    </div>
    </form>
</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>

</body>

</html>