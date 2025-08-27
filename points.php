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

$rank_query = $db->query("
                    SELECT memberID, memberPoints 
                    FROM Member 
                    WHERE status!='alumni'
                    ORDER BY memberPoints DESC, lastName");
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
            <?php if (isset($_SESSION['status']) && in_array($_SESSION['status'], ['member', 'probate', 'social'])) : ?>
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

            <?php elseif ($_SESSION['status'] == "faculty") : ?>
                <h1 class="text-center text-light">Faculty Account</h1>
            <?php endif; ?>
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
                    $top5_query = $db->query("
                        SELECT memberID, firstName, lastName, memberPoints 
                        FROM Member 
                        WHERE status IN ('social', 'member', 'probate')  
                        ORDER BY memberPoints DESC, lastName 
                        LIMIT 5");
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
                    <?php if ($isAdmin || $isEventAdmin): ?>
                        <th scope="col" style="text-align:right;"></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $today = getdate();
                $currentDate = "{$today['mon']}/{$today['mday']}/{$today['year']}";

                // 1️⃣ Fetch events
                $events_query = $db->query("
                    SELECT *
                    FROM Event
                    WHERE isFamilyEvent = '0'
                      AND (
                            (MONTH(CURDATE()) BETWEEN 1 AND 7  AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7)
                         OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12)
                          )
                      AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear), '%m/%d/%Y') <= CURDATE()
                    ORDER BY dateYear DESC, dateMonth DESC, dateDay DESC, eventName
                    LIMIT 10
                ");
                $events = $events_query->fetchAll(PDO::FETCH_ASSOC);

                // 2️⃣ Get event IDs
                $eventIDs = array_column($events, 'eventID');
                if ($eventIDs) {
                    $eventIDList = implode(',', $eventIDs);

                    // 3️⃣ Fetch all attendance records for these events
                    $attends_query = $db->query("
                        SELECT eventID 
                        FROM AttendsEvent 
                        WHERE eventID IN ($eventIDList) AND memberID = $memberID
                    ");
                    $attendedEvents = array_column($attends_query->fetchAll(PDO::FETCH_ASSOC), 'eventID');
                } else {
                    $attendedEvents = [];
                }

                if (empty($events)): ?>
                    <tr><td colspan="4">There are currently no events.</td></tr>
                <?php else:
                    $count = 1;
                    foreach ($events as $row):
                        $eventID = $row['eventID'];
                        $isChecked = in_array($eventID, $attendedEvents) ? 'checked' : '';

                        // Event type badge class
                        $typeClass = match ($row['type']) {
                            'mandatory' => 'event-type-mandatory',
                            'sports'    => 'event-type-sports',
                            'social'    => 'event-type-social',
                            'work'      => 'event-type-work',
                            default     => '',
                        };

                        $editLink = "editEvents.php?dateMonth={$row['dateMonth']}&dateDay={$row['dateDay']}&eventID={$eventID}";

                        ?>
                        <tr id="event-<?= $eventID ?>">
                            <th scope="row">
                                <input id="event<?= $count ?>" class="event-checkbox" type="checkbox" name="<?= $eventID ?>" <?= $isChecked ?>>
                                <label for="event<?= $count ?>"></label>
                            </th>

                            <td><?= $row['dateMonth'] ?>-<?= $row['dateDay'] ?></td>
                            <td>
                                <a href="/event.php?id=<?= $eventID ?>"><?= htmlspecialchars($row['eventName']) ?></a>
                                <?= $row['isBonus'] ? '<span class="text-muted">(BONUS)</span>' : '' ?>
                                <span class="badge badge-primary <?= $typeClass ?>"><?= htmlspecialchars($row['type']) ?></span>

                            </td>
                            <td align="right"><?= $row['pointValue'] ?></td>
                            <?php if ($isAdmin || $isEventAdmin): ?>
                            <td align="right">
                                <a href="<?= $editLink ?>">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php
                        $count++;
                    endforeach;
                    ?>
                    <input type="hidden" name="query_bound" value="recent">
                <?php endif; ?>
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

<?php if ($isEventAdmin || $isAdmin): ?>
    <div class="container mb-4">
        <h4>Create Event</h4>
        <?php require "createEventForm.php" ?>
    </div>
<?php endif; ?>

<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>

<!-- Bootstrap Datepicker Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>



<script>
    // Initialize the datepicker
    document.addEventListener("DOMContentLoaded", function() {
        const datepicker = document.querySelector('.datepicker');
        if (datepicker) {
            new bootstrap.Datepicker(datepicker, {
                format: 'mm/dd/yyyy',
                autoclose: true,
                todayHighlight: true
            });
        }
    });
</script>

</body>

</html>