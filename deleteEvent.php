<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isEventAdmin']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	$tempEventID = $_POST['selectedEventID'];
	
	$query = $db->prepare("DELETE FROM Event WHERE eventID=:tempEventID");
	$query->execute(array('tempEventID'=>$tempEventID));
	
	echo "<h3>Event Deleted</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=recalculatePointsx.php\">";
	
	require "html_footer.txt";
?>