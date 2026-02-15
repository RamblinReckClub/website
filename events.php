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

    // 1️⃣ Fetch events based on month selection
    if ($month == 'all') {
        $query = $db->query("
    SELECT * 
    FROM Event 
    WHERE isFamilyEvent = '0' 
        AND (
            (MONTH(CURDATE()) BETWEEN 1 AND 7  AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7)
         OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12)
          )
    ORDER BY dateYear, dateMonth, dateDay, eventName
");
    } else {
        $query = $db->prepare("
    SELECT * 
    FROM Event 
    WHERE isFamilyEvent = '0' 
        AND (
            (MONTH(CURDATE()) BETWEEN 1 AND 7  AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7)
         OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12)
          )
    AND dateMonth = :month 
    ORDER BY dateYear, dateMonth, dateDay, eventName
");
        $query->execute(['month' => $month]);
    }

    $events = $query->fetchAll(PDO::FETCH_ASSOC);

    // 2️⃣ Fetch attendance for these events
    $eventIDs = array_column($events, 'eventID');
    $attendedEvents = [];

    if ($eventIDs) {
        $eventIDList = implode(',', $eventIDs);
        $attends_query = $db->query("
        SELECT eventID 
        FROM AttendsEvent 
        WHERE eventID IN ($eventIDList) AND memberID = $memberID
    ");
        $attendedEvents = array_column($attends_query->fetchAll(PDO::FETCH_ASSOC), 'eventID');
    }
    ?>

    <div class="float-right">
        <form id="monthSelect" action="/events.php" method="post">
            <select name="dateMonth" class="form-control custom-select" onchange="this.form.submit()">
                <?php
                $months = [
                    '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
                    '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
                    '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                ];
                foreach ($months as $num => $name) {
                    $selected = ($month == $num) ? 'selected' : '';
                    echo "<option value='$num' $selected>$name</option>";
                }
                ?>
                <option value="all" <?= $month == 'all' ? 'selected' : '' ?>>All Events</option>
            </select>
        </form>
    </div>

    <form id="updatePoints" name="updatePoints" action="/updatePoints.php" method="POST">
        <?php if (empty($events)): ?>
            <p>No events recorded for <?= $month == 'all' ? "all months" : $monthName ?>.</p>
        <?php else: ?>
            <table class="table table-hover table-sm mb-3">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Date</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="text-align:right;">Points</th>
                    <?php if ($isAdmin || $isEventAdmin): ?>
                        <th scope="col" style="text-align:right;"></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $row):
                    $eventID = $row['eventID'];
                    $isChecked = in_array($eventID, $attendedEvents) ? 'checked' : '';
                    $editLink = "editEvents.php?dateMonth={$row['dateMonth']}&dateDay={$row['dateDay']}&eventID={$eventID}";

                    // Event type badge
                    $typeClass = match ($row['type']) {
                        'mandatory' => 'event-type-mandatory',
                        'sports'    => 'event-type-sports',
                        'social'    => 'event-type-social',
                        'work'      => 'event-type-work',
                        default     => '',
                    };
                    ?>
                    <tr id="event-<?= $eventID ?>">
                        <td>
                            <input type="checkbox" class="event-checkbox" name="<?= $eventID ?>" <?= $isChecked ?>>
                        </td>
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
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="float-right">
                        <input type="submit" class="btn btn-primary" id="submit-points-button" form="updatePoints" value="Update">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <input type="hidden" name="query_bound" value="<?= $month == 'all' ? 'all' : $month ?>">
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
</body>

</html>