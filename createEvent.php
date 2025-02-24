<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isEventAdmin']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

    $bonusvar = isset($_POST['isBonus']) ? $_POST['isBonus'] : '';
	if($bonusvar == 'on') {
		$bonus = 1;
	} else {
		$bonus = 0;
	}

    $familyeventvar = isset($_POST['isFamilyEvent']) ? $_POST['isFamilyEvent'] : '';
	if($familyeventvar == 'on') {
		$family = 1;
	} else {
		$family = 0;
	}
	
	$query = $db->prepare("INSERT INTO Event (eventName, dateYear, dateMonth, dateDay, pointValue, isBonus, isFamilyEvent, type) VALUES (:eventName, :dateYear, :dateMonth, :dateDay, :pointValue, :bonus, :family, :type)");
	$query->execute(array('eventName'=>$_POST['eventName'], 'dateYear'=>$_POST['dateYear'], 'dateMonth'=>$_POST['dateMonth'], 'dateDay'=>$_POST['dateDay'], 'pointValue'=>$_POST['pointValue'], 'bonus'=>$bonus, 'family'=>$family, 'type'=>$_POST['type']));

	echo "<h3>Event Created</h3>";
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        echo "<meta http-equiv=\"refresh\" content=\"2; url=$previousPage\">";
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"2; url=points.php\">";
    }


require "html_footer.txt";
?>