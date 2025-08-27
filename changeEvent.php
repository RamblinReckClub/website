<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isEventAdmin']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_begin.txt";
    error_log("EVENT ID!!!");
    error_log($_POST['eventID']);

    $newbonusvar = isset($_POST['newIsBonus']) ? $_POST['newIsBonus'] : '';
    if($newbonusvar == 'on') {
        $bonus = 1;
    } else {
        $bonus = 0;
    }

    $newfamilyeventvar = isset($_POST['newIsFamilyEvent']) ? $_POST['newIsFamilyEvent'] : '';
    if($newfamilyeventvar == 'on') {
        $family = 1;
    } else {
        $family = 0;
    }
	
	$query = $db->prepare("UPDATE Event SET eventName=:newEventName, dateYear=:newDateYear, dateMonth=:newDateMonth, dateDay=:newDateDay, pointValue=:newPointValue, isBonus=:bonus, isFamilyEvent=:family, type=:newType WHERE eventID=:eventID");
	$query->execute(array('newEventName'=>$_POST['newEventName'], 'newDateYear'=>$_POST['newDateYear'], 'newDateMonth'=>$_POST['newDateMonth'], 'newDateDay'=>$_POST['newDateDay'], 'newPointValue'=>$_POST['newPointValue'], 'bonus'=>$bonus, 'family'=>$family, 'newType'=>$_POST['newType'], 'eventID'=>$_POST['selectedEventID']));

	echo "<h3>Event Updated</h3>";
echo "<meta http-equiv=\"refresh\" content=\"2; url=recalculatePointsx.php\">";

	require "html_footer.txt";
?>