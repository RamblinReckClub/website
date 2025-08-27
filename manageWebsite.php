<?php
require "logged_in_check.php";
require "set_session_vars_full.php";
require "database_connect.php";
if ($_SESSION['isAdmin']==0) {
    echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
    die;
} else {}
$pageTitle = "Manage Website";
?>

<?php
	$query = $db->query("SELECT DATE_FORMAT(lastBackupDate, '%M %e, %Y %r') AS lastBackup FROM BackupLog;");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$bkupDate = $row['lastBackup'];
	
	$query = $db->query("SELECT * FROM Member WHERE isAdmin = 1 || isEventAdmin = 1 ORDER BY lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$admins = $query->fetchAll();
	
	$query = $db->query("SELECT * FROM Member ORDER BY lastName, firstName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	$members = $query->fetchAll();
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php" ?>
<body>
<?php require "partials/header.php" ?>
<div class="container mb-3">
    <div class="row justify-content-between">
        <h2 class="col-12">Manage Site</h2>
    </div>

    <h4><em>Update Site Permissions</em></h4>
    <form class="mb-4" name="permissions" action="updatePermissions.php" method="POST">
        <div class="row">
            <div class="col-auto">
                <h6><strong>Admins</strong></h6>
                <?php
                foreach($admins as $a) {
                    if($a['isAdmin']==1) {
                        echo "<p>".$a['firstName']." ".$a['lastName']."</p>";
                    }
                }
                ?>
            </div>
            <div class="col-auto">
                <h6><strong>Event Admins</strong></h6>
                <?php
                foreach($admins as $a) {
                    if($a['isEventAdmin']==1) {
                        echo "<p>".$a['firstName']." ".$a['lastName']."</p>";
                    }
                }
                ?>
            </div>
            <div class="col-auto">
                <p class="mb-1"><em>Member:</em></p>
                <select class="form-control custom-select mb-2" name="selectedMember">
                    <option value="none">---</option>
                    <?php
                    foreach($members as $m) {
                        echo "<option value=\"".$m['memberID']."\">".$m['lastName'].", ".$m['firstName']."</option>";
                    }
                    ?>
                </select>
                <p class="mb-1"><em>Role:</em></p>
                <select class="form-control custom-select mb-3" name="selectedRole">
                    <option value="none">---</option>
                    <option value="isAdmin">Admin</option>
                    <option value="isEventAdmin">Event Admin</option>
                </select>
                <input class="btn btn-primary"  type="submit" name="add" value="Add">
                <input class="btn btn-secondary" type="submit" name="remove" value="Remove">
            </div>
        </div>
    </form>

    <h4><em>Other Options</em></h4>
    <div class="row mb-3 align-content-between">
        <div class="col-md-3 col-sm-4">
            <form name="backupDatabase" action="backupDatabasex.php" method="POST">
                <input type=submit class="btn btn-block bnt-md btn-primary" value="Backup Database" onClick="return confirmSubmitBackup()">
            </form>
        </div>
        <div class="col-md-9 col-sm-8">
            <p class="text-muted">This will create a back up table for each table in the database. This allows you to revert to a previous state if an error occurs in the future.</p>
            <p class="text-muted">If a back up already exists, then it will be replaced with a new one based on the current data (IE: there can only be one back up at a time.)</p>
            <p class="text-muted"><?php echo "<u>Date of Last Backup</u>: ".$bkupDate; ?></p>
        </div>
    </div>

    <div class="row mb-3 align-content-between">
        <div class="col-md-3 col-sm-4">
            <form name="phpInfo" action="testinfo.php" method="POST">
                <input class="btn btn-block bnt-md btn-primary" value="Check PHP Version">
            </form>
        </div>
        <div class="col-md-9 col-sm-8">
            <p class="text-muted align-content-center align-content-end" style="vertical-align: middle;">Get information about the current version and configuration of PHP running on the system.</p>
        </div>
    </div>

    <div class="row mb-3 align-content-between">
        <div class="col-md-3 col-sm-4">
            <form name="recalculatePoints" action="recalculatePointsx.php" method="POST">
                <input type=submit class="btn btn-block bnt-md btn-secondary" value="Recalculate Points">
            </form>
        </div>
        <div class="col-md-9 col-sm-8">
            <p class="text-muted">Use this to recalculate member points for the current semester's events. Do this at the beginning of a new semester.</p>
        </div>
    </div>

    <div class="row mb-3 align-content-between">
        <div class="col-md-3 col-sm-4">
            <form name="revertDatabase" action="revertDatabasex.php" method="POST">
                <input type=submit class="btn btn-block bnt-md btn-danger" value="Revert Database Backup" onClick="return confirmSubmitRevert()">
            </form>
        </div>
        <div class="col-md-9 col-sm-8">
            <p class="text-muted">This will overwrite the current version of each table with its corresponding backed up version.</p>
            <p class="text-muted">This action cannot be undone and should only be taken if important data is lost or there is some other serious error with the database.</p>
        </div>
    </div>

    <div class="row align-content-between">
            <div class="col-md-3 col-sm-4">
                <form name="resetPoints" action="resetPointsx.php" method="POST">
                <input type=submit class="btn btn-block bnt-md btn-danger" value="Reset Points and Events" onClick="return confirmSubmitReset()">
                </form>
            </div>
            <div class="col-md-9 col-sm-8">
                <p class="text-muted">WARNING: This will delete all events in the database. Use literally never because now we'll just leave old events in the database.</p>
            </div>
    </div>

</div>
<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
<script type="text/javascript">
    function confirmSubmitBackup()
    {
        var agree=confirm("Are you sure you wish to back up all tables in the database? Any previous back up will be overwritten.");
        if (agree)
            return true;
        else
            return false;
    }
    function confirmSubmitRevert()
    {
        var agree=confirm("Are you sure you wish to revert to the backed up version of the database? This action cannot be undone.");
        if (agree)
            return true;
        else
            return false;
    }
    function confirmSubmitReset()
    {
        var agree=confirm("Are you sure you wish to delete all events and reset points? This action cannot be undone.");
        if (agree)
            return true;
        else
            return false;
    }
</script>
</body>

</html>
