<?php
require "logged_in_check.php";
require "database_connect.php";
require "set_session_vars_full.php";
require "html_header_begin.txt";
?>
<title>Event Attendance | Ramblin' Reck Club</title>
<?php require "html_header_end.txt"; ?>

<h3>Event Attendance</h3>

<div align="center">
    <a href="points.php">Back to Points</a><br/><br/>

<?php
    $currentEventId = $_GET['id'];

    $query = $db->prepare("SELECT eventName, dateYear, dateMonth, dateDay, pointValue, isBonus, isFamilyEvent, type FROM reck_club.Event WHERE eventID=:currentEventId");
    $query->execute(array('currentEventId'=>$currentEventId));
    $query->setFetchMode(PDO::FETCH_ASSOC);

    $row = $query->fetch();

    $currentEventName = $row['eventName'];
    $currentEventMonth = $row['dateMonth'];
    $currentEventDay = $row['dateDay'];
    $currentEventYear = $row['dateYear'];
    $currentEventPoints = $row['pointValue'];
    $currentEventBonusStatus = $row['isBonus'];
    $currentEventFamilyStatus = $row['isFamilyEvent'];
    $currentEventType = $row['type'];
    if ($isAdmin || $isEventAdmin) {
        echo "<a href=\"editEvents.php?dateMonth=" . $currentEventMonth . "&dateDay=" . $currentEventDay . "&eventID=" . $currentEventId . "\">Edit Event</a><br/><br/>";
    }
?>
</div>
    <table align="center">
        <td colspan="5">
            <div id="spacing_div" style="width:400px;"></div>
        </td>
        <tr bgcolor="#b3a369"><th colspan="5">Event: <?php echo $currentEventName; ?></th></tr>
        <tr><td colspan="1">Date:</td>
            <td colspan="3">
                <?php
                    $d=strtotime($currentEventMonth . '/' . $currentEventDay . '/' . $currentEventYear);
                    echo date("F d, Y", $d);
                ?>
            </td>
        </tr>
        <?php
            $typeColor = '#B3A369';
            if ($currentEventType == 'mandatory') {
                $typeColor = '#D0D0D0';
            } else if ($currentEventType == 'sports') {
                $typeColor = '#FFCB00';
            } else if ($currentEventType == 'social') {
                $typeColor = '#005ACE';
            } else if ($currentEventType == 'work') {
                $typeColor = '#149F3D';
            } else {
                $typeColor = '#B3A369';
            }
        ?>
        <tr><td colspan="1">Type:</td><td bgcolor="<?php echo $typeColor; ?>" colspan="3"><?php echo $currentEventType; ?></td></tr>
        <tr><td colspan="1">Total Points:</td><td colspan="3"><?php echo $currentEventPoints; ?></td></tr>
        <tr><td colspan="1">Is Bonus?:</td><td colspan="3"><?php echo (isset($currentEventBonusStatus) && $currentEventBonusStatus == true) ? "Yes" : "No"; ?></td></tr>
        <tr><td colspan="1">Is Family?:</td><td colspan="3"><?php echo (isset($currentEventFamilyStatus) && $currentEventFamilyStatus == true) ? "Yes" : "No"; ?></td></tr>
    </table>
    <table align="center" width="400">
        <tr bgcolor="#b3a369"><th colspan="5">Members in Attendance</th></tr>
<!--        Column Headers if desired -->
<!--        <tr><th colspan="4">Member</th><th colspan="1">Profile</th></tr>-->
        <?php
        $query = $db->prepare("SELECT Member.memberID, Member.firstName, Member.lastName, Member.status FROM reck_club.AttendsEvent JOIN reck_club.Member ON reck_club.AttendsEvent.memberID = reck_club.Member.memberID WHERE reck_club.AttendsEvent.eventID = :currentEventId ORDER BY firstName ASC, lastName");
        $query->execute(array('currentEventId'=>$currentEventId));
        $query->setFetchMode(PDO::FETCH_ASSOC);
        if ($query->rowCount() > 0) {
            $count = 0;
            while($row = $query->fetch()) {
                echo "<form action=\"allAttended.php\" method=\"POST\">";
                echo "<tr><td colspan=\"4\">".$row['firstName']." ".$row['lastName']."</td>";
                echo "<td colspan=\"1\" align=\"center\"><input type=\"submit\" value=\"Check Events\"></td></tr>";
                echo "<input type=\"hidden\" name=\"memberID\" value=\"".$row['memberID']."\">";
                echo "</form>";
//            echo "<tr><td colspan=\"4\">" . $row['firstName']." " . $row['lastName']."</td><td colspan=\"1\">".$row['status']."</td></tr>"; // alternative display if you want
                $count++;
            }

            // Total number of members
            //-------------------------------------------
            $query = $db->query("SELECT COUNT(*) as CNT FROM reck_club.Member WHERE NOT status = 'alumni' AND (NOT username = 'gpburdell' AND NOT username = 'gerome.stephens')"); // remove Gerome and GPB from the member count
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $row = $query->fetch();
            $totalMembers = $row['CNT'];
            $memberPct = number_format(($count/$totalMembers)*100,1);

           echo "<tr bgcolor=\"#b3a369\"><th colspan=\"5\">Overall: " . $count . "/" . $totalMembers . " (" . $memberPct . "%)</th></tr>";
        } else {
            echo "<tr><td>No members attended this event.</td></tr>";
        }
        ?>
    </table>
    <br/><br/><br/><br/>

<?php require "html_footer.txt"; ?>