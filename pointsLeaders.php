<?php
require "logged_in_check.php";
require "database_connect.php";
require "set_session_vars_short.php";
$pageTitle = "All Time Events";
?>

<?php
$pointsInfo = [];
$pointsInfo["Fall 2023"] = array("Austin Gies", 1112, "Matthew Kistner", 1191, "Omar Khan", 1190);
$pointsInfo["Spring 2023"] = array("Keshav Ramanathan", 1112, "Nick Unger", 1191, "Nathan Dailey", 1190);
$pointsInfo["Fall 2022"] = array("Keshav Ramanathan", 1112, "Reid Spencer", 1143, "Charlie Hammer", 1127);
$pointsInfo["Spring 2022"] = array("Jen O'Brien", 1097, "Keshav Ramanathan", 1112, "Matthew Kistner", 1162);
$pointsInfo["Fall 2021"] = array("Keshav Ramanathan", 1112, "Caroline Means", 1064, "Charlie Hammer", 1127);
$pointsInfo["Spring 2021"] = array("Charlie Hammer", 1127, "Caroline Means", 1064, "Keshav Ramanathan", 1112);
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>
<div class="container">
    <h2>Winners' Circle</h2>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col-12">
            <table class="table table-hover table-sm mb-3">
                <?php
                echo "<thead><tr><th>Semester</th><th>1st Place</th><th>2nd Place</th><th>3rd Place</th></tr></thead>";
                echo "<tbody>";
                    foreach ($pointsInfo as $key => $semesterInfo) {
                        $semester = $key;
                        $place1 = $semesterInfo[0];
                        $place1ID = $semesterInfo[1];
                        $place2 = $semesterInfo[2];
                        $place2ID = $semesterInfo[3];
                        $place3 = $semesterInfo[4];
                        $place3ID = $semesterInfo[5];
                        echo "<tr>";
                        echo "<td>" . $semester . "</td>";
                        echo "<td>" . '<a href="/memberProfile.php?memberId=' . $place1ID . '">' . $place1 . '</a>' . "</td>";
                        echo "<td>" . '<a href="/memberProfile.php?memberId=' . $place2ID . '">' . $place2 . '</a>' . "</td>";
                        echo "<td>" . '<a href="/memberProfile.php?memberId=' . $place3ID . '">' . $place3 . '</a>' . "</td></tr>";
                    }
                    echo "</tbody>";
                ?>
            </table>
        </div>
    </div>
</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
</body>

</html>