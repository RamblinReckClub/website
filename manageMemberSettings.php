<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isSecretary']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

	if($_POST['email']=="") { $_POST['email'] = NULL; }
	if($_POST['phone']=="") { $_POST['phone'] = NULL; }
	if($_POST['twitter']=="") { $_POST['twitter'] = NULL; }
	if($_POST['streetAddress']=="") { $_POST['streetAddress'] = NULL; }
	if($_POST['city']=="") { $_POST['city'] = NULL; }
	if($_POST['state']=="") { $_POST['state'] = NULL; }	
	if($_POST['zipCode']=="") { $_POST['zipCode'] = NULL; }
	if($_POST['joinYear']=="") { $_POST['joinYear'] = NULL; }
	if($_POST['gradMonth']=="") { $_POST['gradMonth'] = NULL; }
	if($_POST['gradYear']=="") { $_POST['gradYear'] = NULL; }
	if($_POST['reckerPair']=="") { $_POST['reckerPair'] = NULL; }

	if($_POST['password'] != "") {
        $newPasswordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$query = $db->prepare("UPDATE Member SET username=:username, password=:password, passwordType='bcrypt', firstName=:firstName, lastName=:lastName, email=:email, phone=:phone, twitter=:twitter, streetAddress=:streetAddress, 
			city=:city, state=:state, zipCode=:zipCode, joinYear=:joinYear, gradMonth=:gradMonth, gradYear=:gradYear, reckerPair=:reckerPair, status=:status WHERE memberID = :memberID");
		$query->execute(array('username'=>$_POST['username'], 'password'=>$newPasswordHash, 'firstName'=>$_POST['firstName'], 'lastName'=>$_POST['lastName'], 'email'=>$_POST['email'], 'phone'=>$_POST['phone'], 'twitter'=>$_POST['twitter'],
			'streetAddress'=>$_POST['streetAddress'], 'city'=>$_POST['city'], 'state'=>$_POST['state'], 'zipCode'=>$_POST['zipCode'], 'joinYear'=>$_POST['joinYear'], 
			'gradMonth'=>$_POST['gradMonth'], 'gradYear'=>$_POST['gradYear'], 'reckerPair'=>$_POST['reckerPair'], 'status'=>$_POST['status'], 'memberID'=>$_POST['memberID']));
	} else {
		$query = $db->prepare("UPDATE Member SET username=:username, firstName=:firstName, lastName=:lastName, email=:email, phone=:phone, twitter=:twitter, streetAddress=:streetAddress, 
			city=:city, state=:state, zipCode=:zipCode, joinYear=:joinYear, gradMonth=:gradMonth, gradYear=:gradYear, reckerPair=:reckerPair, status=:status WHERE memberID = :memberID");
		$query->execute(array('username'=>$_POST['username'], 'firstName'=>$_POST['firstName'], 'lastName'=>$_POST['lastName'], 'email'=>$_POST['email'], 'phone'=>$_POST['phone'], 'twitter'=>$_POST['twitter'], 
			'streetAddress'=>$_POST['streetAddress'], 'city'=>$_POST['city'], 'state'=>$_POST['state'], 'zipCode'=>$_POST['zipCode'], 'joinYear'=>$_POST['joinYear'], 
			'gradMonth'=>$_POST['gradMonth'], 'gradYear'=>$_POST['gradYear'], 'reckerPair'=>$_POST['reckerPair'], 'status'=>$_POST['status'], 'memberID'=>$_POST['memberID']));
	}

	echo "<h3>Member Settings Updated</h3>";
	echo "<meta http-equiv=\"refresh\" content=\"2; url=manageMembers.php?selectedMember=".$_POST['memberID']."\">";

	require "html_footer.txt";
?>