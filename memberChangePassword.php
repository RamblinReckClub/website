<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";
	
	require "html_header_begin.txt";
	require "html_header_end.txt";

    $newPasswordHash = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
	
	$query = $db->prepare("UPDATE Member SET password=:password, passwordType='bcrypt', passwordIsTemp=0 WHERE memberID=:memberID");
	$query->execute(array('password'=>$newPasswordHash, 'memberID'=>$_POST["memberID"]));
	
	print("<h3>Password Changed</h3>");
	print("<meta http-equiv=\"refresh\" ");
	print("content=\"2; url=memberProfile.php\">");
	
	require "html_footer.txt";
?>