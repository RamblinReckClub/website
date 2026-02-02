<?php
	require "logged_in_check.php";
	if ($_SESSION['isAdmin']==0 && $_SESSION['isSecretary']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";
	
	$var = false;
	$query = $db->query("SELECT username FROM Member");
		$query->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $query->fetch()) {
		if($row['username'] == $_POST['username']) { $var = true; }
	}
	
	if($var == false) {
        $newPasswordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $oneYearAgo = date('Y-m-d H:i:s', strtotime('-1 year'));
		$query = $db->prepare("INSERT INTO Member (username, password, passwordType, firstName, lastName, status, passwordExpiration) VALUES (:username, :password, 'bcrypt', :firstName, :lastName, :status, :passwordExpiration)");
		$query->execute(array('username'=>$_POST['username'], 'password'=>$newPasswordHash, 'firstName'=>$_POST['firstName'], 'lastName'=>$_POST['lastName'], 'status'=>$_POST['status'], 'passwordExpiration'=>$oneYearAgo));
	
		echo "<h3>Member Created</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"2; url=manageMembers.php\">";
	} else {
		echo "<h3>Username is not unique. Try again.</h3>";
		echo "<meta http-equiv=\"refresh\" content=\"3; url=manageMembers.php\">";
	}

	require "html_footer.txt";
?>