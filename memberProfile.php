<?php
	require "logged_in_check.php";
    require "database_connect.php";
	require "set_session_vars_full.php";
?>
<!DOCTYPE html>
<html>
<?php
    $currentMemberId = isset($_GET['memberId']) ? $_GET['memberId'] : $memberID;
    $query = $db->prepare("SELECT username, firstName, lastName, email, phone, streetAddress, city, state, zipCode, status, joinYear, gradYear, gradMonth, reckerPair, twitter FROM reck_club.Member WHERE memberID=:currentMemberId");
    $query->execute(array('currentMemberId'=>$currentMemberId));
    $query->setFetchMode(PDO::FETCH_ASSOC);

    $currentMember = $query->fetch();
    $pageTitle = "Profile: " . $currentMember['firstName'] . " " . $currentMember['lastName'];

    $readonlyStatus = ($currentMemberId == $memberID || $isAdmin) ? "" : " readonly";
?>
<?php require "partials/head.php"; ?>
<body>
    <?php require "partials/header.php"; ?>
    <div class="container">
        <h3><?php echo $pageTitle; ?></h3>
        <div class="message-space row"></div>
        <div class="row">
            <form class="needs-validation col-12 mb-3" novalidate="" action="memberSettings.php" method="POST">
                <input type="hidden" name="memberID" value="<?php echo $currentMemberId; ?>">
                <h4 class="mb-3">Personal Information</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" name="firstName" size=32 maxlength=32 value="<?php echo ($currentMember['firstName']); ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" name="lastName" size=32 maxlength=32 value="<?php echo ($currentMember['lastName']); ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Valid last name is required.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="member-username">Username</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="username" size=32 maxlength=32 value="<?php echo($currentMember['username']) ?>" disabled>
                        <div class="invalid-feedback" style="width: 100%;">
                            Your username is required.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="member-email">Email Address</label>
                    <input type="email" class="form-control" name="email" size=32 maxlength=32 value="<?php echo($currentMember['email']) ?>" <?php echo $readonlyStatus; ?>>
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>
                <hr class="mb-4">
                <h4 class="mb-3">Contact Information</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" value="<?php echo($currentMember['phone']) ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Please enter a valid phone number.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="twitter">Twitter Username</label>
                        <input type="text" class="form-control" name="twitter" value="<?php echo($currentMember['twitter']) ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Please enter a valid phone number.
                        </div>
                    </div>
                </div>
                <h5 class="mb-3">Address</h5>
                <div class="mb-3">
                    <label for="address">Street Address</label>
                    <input type="text" class="form-control" name="streetAddress" value="<?php echo($currentMember['streetAddress']) ?>" <?php echo $readonlyStatus; ?>>
                    <div class="invalid-feedback">
                        Please enter your home street address.
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" value="<?php echo ($currentMember['city']); ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Please enter your home city.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="member-state">State</label>
                        <?php if ($currentMemberId == $memberID || $isAdmin): ?>
                            <select class="custom-select d-block w-100" name="state">
                                <option value="" <?PHP if($currentMember['state']==NULL) echo "selected";?>>---</option>
                                <option value="AL" <?PHP if($currentMember['state']=="AL") echo "selected";?>>AL</option>
                                <option value="AK" <?PHP if($currentMember['state']=="AK") echo "selected";?>>AK</option>
                                <option value="AZ" <?PHP if($currentMember['state']=="AZ") echo "selected";?>>AZ</option>
                                <option value="AR" <?PHP if($currentMember['state']=="AR") echo "selected";?>>AR</option>
                                <option value="CA" <?PHP if($currentMember['state']=="CA") echo "selected";?>>CA</option>
                                <option value="CO" <?PHP if($currentMember['state']=="CO") echo "selected";?>>CO</option>
                                <option value="CT" <?PHP if($currentMember['state']=="CT") echo "selected";?>>CT</option>
                                <option value="DE" <?PHP if($currentMember['state']=="DE") echo "selected";?>>DE</option>
                                <option value="FL" <?PHP if($currentMember['state']=="FL") echo "selected";?>>FL</option>
                                <option value="GA" <?PHP if($currentMember['state']=="GA") echo "selected";?>>GA</option>
                                <option value="HI" <?PHP if($currentMember['state']=="HI") echo "selected";?>>HI</option>
                                <option value="ID" <?PHP if($currentMember['state']=="ID") echo "selected";?>>ID</option>
                                <option value="IL" <?PHP if($currentMember['state']=="IL") echo "selected";?>>IL</option>
                                <option value="IN" <?PHP if($currentMember['state']=="IN") echo "selected";?>>IN</option>
                                <option value="IA" <?PHP if($currentMember['state']=="IA") echo "selected";?>>IA</option>
                                <option value="KS" <?PHP if($currentMember['state']=="KS") echo "selected";?>>KS</option>
                                <option value="KY" <?PHP if($currentMember['state']=="KY") echo "selected";?>>KY</option>
                                <option value="LA" <?PHP if($currentMember['state']=="LA") echo "selected";?>>LA</option>
                                <option value="ME" <?PHP if($currentMember['state']=="ME") echo "selected";?>>ME</option>
                                <option value="MD" <?PHP if($currentMember['state']=="MD") echo "selected";?>>MD</option>
                                <option value="MA" <?PHP if($currentMember['state']=="MA") echo "selected";?>>MA</option>
                                <option value="MI" <?PHP if($currentMember['state']=="MI") echo "selected";?>>MI</option>
                                <option value="MN" <?PHP if($currentMember['state']=="MN") echo "selected";?>>MN</option>
                                <option value="MS" <?PHP if($currentMember['state']=="MS") echo "selected";?>>MS</option>
                                <option value="MO" <?PHP if($currentMember['state']=="MO") echo "selected";?>>MO</option>
                                <option value="MT" <?PHP if($currentMember['state']=="MT") echo "selected";?>>MT</option>
                                <option value="NE" <?PHP if($currentMember['state']=="NE") echo "selected";?>>NE</option>
                                <option value="NV" <?PHP if($currentMember['state']=="NV") echo "selected";?>>NV</option>
                                <option value="NH" <?PHP if($currentMember['state']=="NH") echo "selected";?>>NH</option>
                                <option value="NJ" <?PHP if($currentMember['state']=="NJ") echo "selected";?>>NJ</option>
                                <option value="NM" <?PHP if($currentMember['state']=="NM") echo "selected";?>>NM</option>
                                <option value="NY" <?PHP if($currentMember['state']=="NY") echo "selected";?>>NY</option>
                                <option value="NC" <?PHP if($currentMember['state']=="NC") echo "selected";?>>NC</option>
                                <option value="ND" <?PHP if($currentMember['state']=="ND") echo "selected";?>>ND</option>
                                <option value="OH" <?PHP if($currentMember['state']=="OH") echo "selected";?>>OH</option>
                                <option value="OK" <?PHP if($currentMember['state']=="OK") echo "selected";?>>OK</option>
                                <option value="OR" <?PHP if($currentMember['state']=="OR") echo "selected";?>>OR</option>
                                <option value="PA" <?PHP if($currentMember['state']=="PA") echo "selected";?>>PA</option>
                                <option value="RI" <?PHP if($currentMember['state']=="RI") echo "selected";?>>RI</option>
                                <option value="SC" <?PHP if($currentMember['state']=="SC") echo "selected";?>>SC</option>
                                <option value="SD" <?PHP if($currentMember['state']=="SD") echo "selected";?>>SD</option>
                                <option value="TN" <?PHP if($currentMember['state']=="TN") echo "selected";?>>TN</option>
                                <option value="TX" <?PHP if($currentMember['state']=="TX") echo "selected";?>>TX</option>
                                <option value="UT" <?PHP if($currentMember['state']=="UT") echo "selected";?>>UT</option>
                                <option value="VT" <?PHP if($currentMember['state']=="VT") echo "selected";?>>VT</option>
                                <option value="VA" <?PHP if($currentMember['state']=="VA") echo "selected";?>>VA</option>
                                <option value="WA" <?PHP if($currentMember['state']=="WA") echo "selected";?>>WA</option>
                                <option value="WV" <?PHP if($currentMember['state']=="WV") echo "selected";?>>WV</option>
                                <option value="WI" <?PHP if($currentMember['state']=="WI") echo "selected";?>>WI</option>
                                <option value="WY" <?PHP if($currentMember['state']=="WY") echo "selected";?>>WY</option>
                            </select>
                        <?php else: ?>
                            <input type="text" class="form-control" size=15 maxlength=5 name="state" value="<?php echo($currentMember['state']) ?>" <?php echo $readonlyStatus; ?>>
                        <?php endif; ?>
                        <div class="invalid-feedback">
                            Please provide a valid state.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zipCode">Zip Code</label>
                        <input type="text" class="form-control" size=15 maxlength=5 name="zipCode" value="<?php echo($currentMember['zipCode']) ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Zip code required.
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <h4 class="mb-3">Member Information</h4>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="joinYear">Probate Class</label>
                        <input type="text" class="form-control" size=32 maxlength=4 name="joinYear" value="<?php echo($currentMember['joinYear']) ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Probate class required.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="status">Current status</label>
                        <?php if ($currentMemberId == $memberID || $isAdmin): ?>
                        <select class="custom-select d-block w-100" name="status" <?php echo $readonlyStatus; ?>>
                            <option value="probate" <?php if ($currentMember['status'] == 'probate') echo "selected";?>>Probate</option>
                            <option value="member" <?php if ($currentMember['status'] == 'member') echo "selected";?>>Member</option>
                            <option value="alumni" <?php if ($currentMember['status'] == 'alumni') echo "selected";?>>Alumni</option>
                        </select>
                        <?php else: ?>
                        <input type="text" class="form-control" size=15 maxlength=5 name="status" value="<?php echo ucfirst($currentMember['status']); ?>" <?php echo $readonlyStatus; ?>>
                        <?php endif; ?>
                        <div class="invalid-feedback">
                            Member status required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reckerPair">Big Recker Pair</label>
                        <?php if ($currentMemberId == $memberID || $isAdmin): ?>
                        <select class="custom-select d-block w-100" name="reckerPair" <?php echo $readonlyStatus; ?>>
                            <option value="" <?PHP if($currentMember['reckerPair']==NULL) echo "selected";?>>---</option>
                            <?php
                            $query = $db->query("SELECT memberID, firstName, lastName FROM Member ORDER BY lastName");
                            $query->setFetchMode(PDO::FETCH_ASSOC);
                            while($row = $query->fetch()) {
                                echo "<option value=\"";
                                echo $row['memberID'];
                                echo "\"";
                                if($currentMember['reckerPair'] == $row['memberID']) {
                                    echo " selected";
                                }
                                echo ">".$row['firstName']." ".$row['lastName']."</option>";
                            }
                            ?>
                        </select>
                        <?php else: ?>
                        <?php
                            $query = $db->prepare("SELECT firstName, lastName FROM reck_club.Member WHERE memberID=:reckerPairID");
                            $query->execute(array('reckerPairID'=>$currentMember['reckerPair']));
                            $query->setFetchMode(PDO::FETCH_ASSOC);

                            $reckerPair = $query->fetch();
                            if($reckerPair=="") {
                                $reckerPair = array('firstName'=>"", 'lastName'=>"");
                            }

                        ?>
                        <input type="text" class="form-control" size=15 maxlength=5 name="reckerPair" value="<?php echo($reckerPair['firstName'] . " " . $reckerPair['lastName']) ?>" <?php echo $readonlyStatus; ?>>
                        <?php endif; ?>
                        <div class="invalid-feedback">
                            Please provide a valid recker pair.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gradMonth">Grad Month</label>
                        <?php if ($currentMemberId == $memberID || $isAdmin): ?>
                        <select class="custom-select d-block w-100" name="gradMonth">
                            <option value=""  <?PHP if($currentMember['gradMonth']==NULL) echo "selected";?>>---</option>
                            <option value="01"  <?PHP if($currentMember['gradMonth']==1) echo "selected";?>>January</option>
                            <option value="02"  <?PHP if($currentMember['gradMonth']==2) echo "selected";?>>February</option>
                            <option value="03"  <?PHP if($currentMember['gradMonth']==3) echo "selected";?>>March</option>
                            <option value="04"  <?PHP if($currentMember['gradMonth']==4) echo "selected";?>>April</option>
                            <option value="05"  <?PHP if($currentMember['gradMonth']==5) echo "selected";?>>May</option>
                            <option value="06"  <?PHP if($currentMember['gradMonth']==6) echo "selected";?>>June</option>
                            <option value="07"  <?PHP if($currentMember['gradMonth']==7) echo "selected";?>>July</option>
                            <option value="08"  <?PHP if($currentMember['gradMonth']==8) echo "selected";?>>August</option>
                            <option value="09"  <?PHP if($currentMember['gradMonth']==9) echo "selected";?>>September</option>
                            <option value="10" <?PHP if($currentMember['gradMonth']==10) echo "selected";?>>October</option>
                            <option value="11" <?PHP if($currentMember['gradMonth']==11) echo "selected";?>>November</option>
                            <option value="12" <?PHP if($currentMember['gradMonth']==12) echo "selected";?>>December</option>
                        </select>
                        <?php else: ?>
                            <input type="text" class="form-control" size=15 maxlength=5 name="gradMonth" value="<?php echo($currentMember['gradMonth']) ?>" <?php echo $readonlyStatus; ?>>
                        <?php endif; ?>
                        <div class="invalid-feedback">
                            Please provide a valid grad month.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="gradYear">Grad Year</label>
                        <input type="text" class="form-control" name="gradYear" size=15 maxlength=4 value="<?php echo($currentMember['gradYear']) ?>" <?php echo $readonlyStatus; ?>>
                        <div class="invalid-feedback">
                            Grad year required.
                        </div>
                    </div>
                </div>
                <?php if ($currentMemberId == $memberID || $isAdmin): ?>
                <button class="btn btn-primary btn-lg btn-block" onsubmit="return validate();" type="submit">Update profile</button>
                <?php endif; ?>
            </form>
        </div>

        <?php if ($currentMemberId == $memberID || $isAdmin): ?>
        <div class="row">
            <div class="col-12">
                <hr class="mb-4">
                <h4 class="mb-3">Change Password</h4>
                <form name="thisform" class="mb-3" onsubmit="return passwordCheck();" action="memberChangePassword.php" method="POST">
                    <input type="hidden" name="memberID" value="<?php echo $currentMemberId; ?>">
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" size=32 maxlength=32 name="newPassword" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password">Confirm Password</label>
                            <input type="password" class="form-control" size=32 maxlength=32 name="confirmPassword" required>
                        </div>
                    </div>
                    <input class="btn btn-primary btn-md float-right" type="submit" value="Change Password">
                </form>
            </div>
        </div>
        <?php endif; ?>

    </div>

<?php include "partials/footer.php" ?>
<?php include "partials/scripts.php" ?>
<script type="text/javascript">
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
    function validate() {
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
    function hasWhiteSpace(s) {
        return s.indexOf(' ') >= 0;
    }
    function passwordCheck() {
        if (hasWhiteSpace(document.thisform.newPassword.value)) {
            alert("Error: Password cannot contain a space. Try again.");
            document.thisform.newPassword.focus();
            return false;
        }
        if (document.thisform.newPassword.value != document.thisform.confirmPassword.value) {
            alert("Error: Password does not match. Try again.");
            document.thisform.newPassword.focus();
            return false;
        }
        return true;
    }
</script>

</body>

</html>
