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

	// CALCULATE ALL MEMBERS' TOTAL POINTS
	//------------------------------------
	
	$resultMem = $db->query("SELECT memberID FROM Member WHERE status != 'alumni'");
		$resultMem->setFetchMode(PDO::FETCH_ASSOC);
	
	while($rowMem = $resultMem->fetch()) {
	
	    $tempMemberID = $rowMem['memberID'];
	    
		$query = $db->prepare("SELECT pointValue, type FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE memberID = :tempMemberID");
		$query->execute(array('tempMemberID'=>$tempMemberID));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		
		$num = 0;
		$mandatory = 0;
		$sports = 0;
		$social = 0;
		$work = 0;
		
		while($row = $query->fetch()) {
			if($row['type']=='mandatory'){
				$mandatory++;
				$num += $row['pointValue'];
			}
			else if($row['type']=='sports'){
				$sports++;
				$num += $row['pointValue'];
			}
			else if($row['type']=='social'){
				$social++;
				$num += $row['pointValue'];
			}
			else if($row['type']=='work'){
				$work++;
				$num += $row['pointValue'];
			}		
		}

	// SET ALL MEMBERS' TOTAL POINTS IN DATABASE
	//------------------------------------------------------

		$query2 = $db->prepare("UPDATE Member SET memberPoints = :num, mandatoryEventCount = :mandatory, sportsEventCount = :sports, socialEventCount = :social, workEventCount = :work WHERE memberID = :tempMemberID");
		$query2->execute(array('num'=>$num, 'mandatory'=>$mandatory, 'sports'=>$sports, 'social'=>$social, 'work'=>$work, 'tempMemberID'=>$tempMemberID));

    }
                     
	// CALCULATE ALL FAMILIES' TOTAL POINTS
	//-------------------------------------

	$resultFam = $db->query("SELECT familyID FROM Family");
		$resultFam->setFetchMode(PDO::FETCH_ASSOC);
	         
	while($rowFam = $resultFam->fetch()) {
	
	    $tempFamilyID = $rowFam['familyID'];
	    
	    $famnum = 0;
	    
		$query = $db->prepare("SELECT SUM(points) AS pts FROM 
								(SELECT SUM(pointValue) AS points FROM Member JOIN (AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID) ON Member.memberID = AttendsEvent.memberID WHERE Member.memFamilyID = :tempFamilyID AND (Member.status != 'alumni')
								UNION ALL
								SELECT SUM(pointValue) FROM AttendsEvent JOIN Event ON AttendsEvent.eventID = Event.eventID WHERE AttendsEvent.familyID = :tempFamilyID AND AttendsEvent.memberID IS NULL) subquery");
		$query->execute(array('tempFamilyID'=>$tempFamilyID));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		$famnum = $row['pts'];
					
	// SET ALL FAMILIES' TOTAL POINTS IN DATABASE
	// ------------------------------------------
	
		$query2 = $db->prepare("UPDATE Family SET familyPoints = :famnum WHERE familyID = :tempFamilyID");
		$query2->execute(array('famnum'=>$famnum, 'tempFamilyID'=>$tempFamilyID));
	
	}
	
	echo "<h3>Event Deleted</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=editEvents.php\">";
	
	require "html_footer.txt";
?>