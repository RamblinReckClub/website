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
<div class="container mb-3">
    <div class="row mb-3">
        <h2 class="col-md-8 col-sm-auto">Families</h2>
        <div class="col-md-4 col-sm-auto">
            <div class="btn-group float-md-right">
                <?php
                if($_SESSION[isAdmin]==1 || $_SESSION[isVP]==1) {
                    echo "<form action=\"familyEvents.php\" method=\"POST\">";
                    echo "<button type=\"submit\" class='btn btn-secondary'  value=\"Family Events\">Family Events</button>";
                    echo "</form>";
                    echo "<form action=\"editFamilies.php\" method=\"POST\">";
                    echo "<button type=\"submit\" class='ml-2 btn btn-primary' value=\"Edit Families\">Edit Families</button>";
                    echo "</form>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php
            $fam_query = $db->query("select count(*) from Family;");
            $result = $fam_query->fetch()[0];
            for ($id = 1; $id <= $result; $id++) {
                if ($id % 2 == 1) {
                    echo '<div class="row mb-3">';
                }
                echo '<div class="col-md-6 col-sm-12">';
                $query = $db->prepare("SELECT familyName,familyPoints FROM Family WHERE familyID=:familyId");
                $query->execute(["familyId" => $id]);
                $row = $query->fetch();
                $familyTitle = (strlen($row['familyName']) > 0) ? $row['familyName'] : ('Family ' . $id);
                echo '<h4 class="m-0">' . $familyTitle .'</h4>';
                $famPoints = (isset($row['familyPoints']) ? $row['familyPoints'] : '0');
                echo '<p class="text-primary mb-2">Points: ' . $famPoints . '</p>';

                $query = $db->prepare("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=:familyId AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
                $query->execute(["familyId" => $id]);
                $query->setFetchMode(PDO::FETCH_ASSOC);
                if ($query->rowCount() > 0) {
                    echo '<table class="table table-sm table-hover">
                        <thead>
                        <th scope="col">Member</th>
                        <th scope="col" style="text-align:right !important; ">Points</th>
                        </thead>
                        <tbody>';
                    while($row = $query->fetch()) {
                        echo "<tr><td>" . $row['firstName'] . " " . $row['lastName'] . "</td><td align=\"right\">" . $row['memberPoints'] . "</td></tr>";
                    }
                    echo "</tbody>";
                    echo"</table>";
                } else {
                    echo '<p>No members are assigned to this family.</p>';
                }
                echo '</div>';
                if ($id % 2 == 0) {
                    echo '</div>';
                }
            }
        ?>

</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>

</body>

</html>