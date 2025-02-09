<?php
	session_start();
	if (!isset($_SESSION['memberID'])) {
                                           echo "<meta http-equiv=\"REFRESH\" content=\"0;url=memberLoginForm.php\">";
                                           die;
                     } else {
                                           // SET SESSION VARIABLES

		$loggedIn = true;
		$memberID = $_SESSION['memberID'];
		$username = $_SESSION['username'];
		$firstName = $_SESSION['firstName'];
		$lastName = $_SESSION['lastName'];
		$email = $_SESSION['email'];
		$phone = $_SESSION['phone'];
		$twitter = $_SESSION['twitter'];
        $streetAddress = $_SESSION['streetAddress'];
        $city = $_SESSION['city'];
        $state = $_SESSION['state'];
        $zipCode = $_SESSION['zipCode'];
		$status = $_SESSION['status'];
		$joinYear = $_SESSION['joinYear'];
		$gradYear = $_SESSION['gradYear'];
		$gradMonth = $_SESSION['gradMonth'];
		$reckerPair = $_SESSION['reckerPair'];
		$memFamilyID = $_SESSION['memFamilyID'];
		$isAdmin = $_SESSION['isAdmin'];
		$isSecretary = $_SESSION['isSecretary'];
		$isTreasurer = $_SESSION['isTreasurer'];
		$isVP = $_SESSION['isVP'];
		$isEventAdmin = $_SESSION['isEventAdmin'];

	                     // CONNECT TO THE mySQL DATABASE

	                     $mysql_host = "mysql.localhost";
	                     $mysql_db = "reck_club";
	                     $mysql_user = "reck";
	                     $mysql_password = "burdell";
	                     $mysql_link = mysql_connect($mysql_host, $mysql_user, $mysql_password)
		                     or die("Error connecting to database: ".mysql_error());
	                     mysql_select_db($mysql_db)
		                     or die("Error accessing database: ".mysql_error());
?>
<html>
<head>

<?php
                                           echo "<title>Ramblin' Reck Club</title>";
                                           echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">";
										   echo "<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>";
                                           echo "<link href=\"css/style.css\" rel=\"stylesheet\" type=\"text/css\">";
										   echo "<script type=\"text/javascript\" language=\"JavaScript\">";
										   echo "NumberOfImagesToRotate = 18;";
										   echo "FirstPart = '<img src=\"images/snap';";
										   echo "LastPart = '.jpg\">';";
										   echo "function printImage() {";
										   echo "var r = Math.ceil(Math.random() * NumberOfImagesToRotate);";
										   echo "document.write(FirstPart + r + LastPart);}</script>";

                      }
					  

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>


<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery(".pie").hide();
  //toggle the componenet with class msg_body
  $(".breakdown").click(function()
  {
    jQuery(".pie").slideToggle('slow', function() {
    // Animation complete.
  });
  });
});
</script>


</head>
<body><br />