<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isSecretary']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	}
    require "set_session_vars_full.php";
    require "database_connect.php";
    $pageTitle = "Manage Members";
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<style>
    #memberProfileUrl:disabled,
    #memberProfileUrl[disabled]{
        border: 1px solid #AAA;
        background-color: #AAA;
    }
</style>
<body>
<?php require "partials/header.php"; ?>

<?php
	@$selectedMember=$_GET['selectedMember'];
	
	if(isset($selectedMember)) {
	} else {
	    $selectedMember = "none";
	}

	$query = $db->query("SELECT firstName, lastName, memberID FROM Member ORDER BY lastName");
		$query->setFetchMode(PDO::FETCH_ASSOC);
?>
<div class="container mb-3">
    <h3>Manage Members</h3>


<div class="row">
    <form class="col-12">
        <h4 class="mb-3">Edit Member</h4>
        <div class="offset-md-3 col-md-6 col-xs-12 mb-3">
            <label for="memberID">Member Name </label>
            <select class="custom-select d-block w-100 mb-3" name="editMemberID" id="editMemberID">
                <option value="">---</option>
                <?php
                while($row3 = $query->fetch()) {
                    echo "<option value=\"".$row3['memberID']."\" ";
                    if($selectedMember==$row3['memberID']) {
                        echo "selected";
                    }
                    echo ">".$row3['lastName'].", ".$row3['firstName']."</option>";
                }
                ?>
            </select>
            <button id="memberProfileUrl" class="btn btn-primary btn-md btn-block" disabled>Go to member profile</button>
        </div>
    </form>
</div>

<?php
	if($selectedMember != "none") {
		$query2 = $db->query("SELECT * FROM Member WHERE memberID = $selectedMember");
			$query2->setFetchMode(PDO::FETCH_ASSOC);
		
		$row2 = $query2->fetch();
	}

if($selectedMember != "none") {
?>



<?php
} else{
?>


    <div class="row">
        <form class="col-12" name="createForm" onsubmit="return validateCreate();" action="createMember.php" method="POST">
            <h4 class="mb-3">Create Member</h4>
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="gpburdell" value="" required="" size="32" maxlength="32">
                    <div class="invalid-feedback">
                        Valid username is required.
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="reckclub1930" value="" size="32" maxlength="32">
                    <div class="invalid-feedback">
                        Valid password is required.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" name="firstName" placeholder="George" value="" required="" size="32" maxlength="32">
                    <div class="invalid-feedback">
                        Valid username is required.
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" name="lastName" placeholder="Burdell" value="" required="" size="32" maxlength="32">
                    <div class="invalid-feedback">
                        Valid password is required.
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <label for="gtUsername">GT Username</label>
                    <input type="text" class="form-control" name="gtUsername" placeholder="gburdell3" value="" size="32" maxlength="32">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label for="status">Status</label>
                    <select class="custom-select d-block w-100 mb-3" name="status" id="status">
                    <option value="probate">Probate</option>
                    <option value="member">Member</option>
                    <option value="social">Social</option>
                    <option value="alumni">Alumni</option>
                    <option value="alumni">Faculty</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6 col-xs-12 mb-3">
                    <button class="btn btn-primary btn-md btn-block" type="submit">Create member</button>
                </div>
            </div>
        </form>
    </div>

    <?php
        $query3 = $db->query("SELECT memberID, firstName, lastName FROM Member ORDER BY lastName");
        $query3->setFetchMode(PDO::FETCH_ASSOC);
    ?>

    <div class="row">
        <form class="col-12" name="deleteForm" action="deleteMember.php" method="POST">
            <h4 class="mb-3">Delete Member</h4>
            <div class="row">
                <div class="offset-md-3 col-md-6 col-xs-12 mb-3">
                    <label for="memberID">Member Name </label>
                    <select class="custom-select d-block w-100 mb-3" name="memberID" id="memberID">
                        <option value="">---</option>
                        <?php
                        while($row3 = $query3->fetch()) {
                            echo "<option value=\"".$row3['memberID']."\" ";
                            if($selectedMember==$row3['memberID']) {
                                echo "selected";
                            }
                            echo ">".$row3['lastName'].", ".$row3['firstName']."</option>";
                        }
                        ?>
                    </select>
                    <button class="btn btn-danger btn-md btn-block" type="submit" onClick="return confirmSubmit()">Delete member</button>
                </div>
            </div>
        </form>
    </div>


<?php
}
?>
</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
<SCRIPT type="text/javascript">
    function confirmSubmit()
    {
        var agree=confirm("Are you sure you wish to DELETE this member?");
        if (agree)
            return true ;
        else
            return false ;
    }
    var whitespace = " \t\n\r";
    function isEmpty(s) {
        var i;
        if((s == null) || (s.length == 0))
            return true;
        // Search string looking for characters that are not whitespace
        for (i = 0; i < s.length; i++) {
            var c = s.charAt(i);
            if (whitespace.indexOf(c) == -1)
                return false;
        }
        // At this point all characters are whitespace.
        return true;
    }
    var intRegex = /^\d+$/;
    function hasWhiteSpace(s) {
        return s.indexOf(' ') >= 0;
    }
    function validate() {
        if (isEmpty(document.myform.username.value)) {
            alert("Error: Username is required.");
            document.myform.username.focus();
            return false;
        }
        if (hasWhiteSpace(document.myform.username.value)) {
            alert("Error: Username cannot contain a space. Try again.");
            document.myform.username.focus();
            return false;
        }
        if (hasWhiteSpace(document.myform.password.value)) {
            alert("Error: Password cannot contain a space. Try again.");
            document.myform.password.focus();
            return false;
        }
        if (isEmpty(document.myform.firstName.value)) {
            alert("Error: First name is required.");
            document.myform.firstName.focus();
            return false;
        }
        if (isEmpty(document.myform.lastName.value)) {
            alert("Error: Last name is required.");
            document.myform.lastName.focus();
            return false;
        }
        if (!intRegex.test(document.myform.zipCode.value) && !isEmpty(document.myform.zipCode.value)) {
            alert("Error: Zip code must be an integer.");
            document.myform.zipCode.focus();
            return false;
        }
        if (!intRegex.test(document.myform.joinYear.value) && !isEmpty(document.myform.joinYear.value)) {
            alert("Error: Join year must be an integer.");
            document.myform.joinYear.focus();
            return false;
        }
        if (!intRegex.test(document.myform.gradYear.value) && !isEmpty(document.myform.gradYear.value)) {
            alert("Error: Graduation year must be an integer.");
            document.myform.gradYear.focus();
            return false;
        }
        return true;
    }
    function validateCreate() {
        if (isEmpty(document.createForm.username.value)) {
            alert("Error: Username is required.");
            document.createForm.username.focus();
            return false;
        }
        if (hasWhiteSpace(document.createForm.username.value)) {
            alert("Error: Username cannot contain a space. Try again.");
            document.createForm.username.focus();
            return false;
        }
        if (hasWhiteSpace(document.createForm.password.value)) {
            alert("Error: Password cannot contain a space. Try again.");
            document.createForm.password.focus();
            return false;
        }
        if (isEmpty(document.createForm.firstName.value)) {
            alert("Error: First name is required.");
            document.createForm.firstName.focus();
            return false;
        }
        if (isEmpty(document.createForm.lastName.value)) {
            alert("Error: Last name is required.");
            document.createForm.lastName.focus();
            return false;
        }
        return true;
    }
    function reload(form){
        var selectedMember=form.selectedMember.options[form.selectedMember.options.selectedIndex].value;
        self.location='manageMembers.php?selectedMember=' + selectedMember;
    }
</SCRIPT>
<script>
    $(function(){
        // bind change event to select
        $('#editMemberID').on('change', function () {
            var memberId = $(this).val(); // get selected value
            $('#memberProfileUrl').on('click', function(e) {
                e.preventDefault();
                window.location = '/memberProfile.php?memberId=' + memberId;
            });
            $('#memberProfileUrl').attr('disabled', false)
            return false;
        });
    });
</script>
</body>
</html>