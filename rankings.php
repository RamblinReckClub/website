<?php
require "logged_in_check.php";
require "set_session_vars_full.php";
require "database_connect.php";
$pageTitle = "Members";
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>
<?php
	@$sortBy=$_GET['sortBy'];
	
	if(isset($sortBy)) {
	} else {
	    $sortBy = "all";
	}
?>
<div class="container">
<div class="row mb-1">
    <div class="col-md-10">
        <h3>Members</h3>
    </div>
    <div class="col-md-2">
        <form>
            <select class="form-control float-right custom-select" name="sortBy" id="sortBy" onChange="reload(this.form)">
                <option value="all"  <?PHP if($sortBy=="all") echo "selected";?>>All</option>
                <option value="members"  <?PHP if($sortBy=="members") echo "selected";?>>Members</option>
                <option value="probates"  <?PHP if($sortBy=="probates") echo "selected";?>>Probates</option>
                <option value="social"  <?PHP if($sortBy=="social") echo "selected";?>>Social</option>
            </select>
        </form>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <a href="/stats.php" class="float-right">More fun stats</a>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <table class="table table-hover table-sm mb-3">
            <thead>
                <tr>
                    <!--<th scope="col">Rank</th> -->
                    <th scope="col">Name</th>
<!--                    <td scope="col" align="right"><b>Total Events</b></td>-->
                    <!--<td scope="col" align="right"><b>Total Points</b></td>-->
                </tr>
            </thead>
            <tbody>
            <?php

                // CREATE TABLE OF INDIVIDUAL RANKINGS
                //---------------------------------------------------

                if($sortBy=="all") {
                    $query = $db->query("SELECT firstName, lastName, memberPoints, memberID, mandatoryEventCount, sportsEventCount, socialEventCount, workEventCount FROM Member WHERE status!='alumni' ORDER BY firstName DESC, lastName");
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                } elseif($sortBy=="members") {
                    $query = $db->query("SELECT firstName, lastName, memberPoints, memberID, mandatoryEventCount, sportsEventCount, socialEventCount, workEventCount FROM Member WHERE status='member' ORDER BY firstName DESC, lastName");
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                } elseif($sortBy=="probates") {
                    $query = $db->query("SELECT firstName, lastName, memberPoints, memberID, mandatoryEventCount, sportsEventCount, socialEventCount, workEventCount FROM Member WHERE status='probate' ORDER BY firstName DESC, lastName");
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                } elseif($sortBy=="social") {
                    $query = $db->query("SELECT firstName, lastName, memberPoints, memberID, mandatoryEventCount, sportsEventCount, socialEventCount, workEventCount FROM Member WHERE status='social' ORDER BY firstName DESC, lastName");
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                }

                $count = 1;

                while($row = $query->fetch())
                    {
                    echo "<form action=\"allAttended.php\" method=\"POST\">";
                    echo "<tr><th>".$count."</th>";
                    echo "<td><input class='btn btn-link p-0' type=\"submit\" value=\"".$row['firstName']." ".$row['lastName']."\"></td>";
//                    echo "<td align='right'>".($row['mandatoryEventCount'] + $row['sportsEventCount'] + $row['socialEventCount'] + $row['workEventCount'])."</td>";
                    echo "<td align=\"right\">".$row['memberPoints']."</td>";
//                    echo "<td align=\"right\"><input class='btn btn-link' type=\"submit\" value=\"Check Events\"></td></tr>";
                    echo "<input type=\"hidden\" name=\"memberID\" value=\"".$row['memberID']."\">";
                    echo "</form>";
                    $count++;
                    }
            ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
<script>
    function reload(form){
        var sortBy=form.sortBy.options[form.sortBy.options.selectedIndex].value;
        self.location='rankings.php?sortBy=' + sortBy;
    }
</script>
</body>

</html>