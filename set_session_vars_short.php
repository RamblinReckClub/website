<?php
	$memberID = $_SESSION['memberID'];
	$username = $_SESSION['username'];
	$firstName = $_SESSION['firstName'];
	$lastName = $_SESSION['lastName'];
	$isAdmin = $_SESSION['isAdmin'];
	$isSecretary = $_SESSION['isSecretary'];
	$isTreasurer = $_SESSION['isTreasurer'];
	$isVP = $_SESSION['isVP'];
	$isEventAdmin = $_SESSION['isEventAdmin'];
	$isProbateGuide = isset($_SESSION['isProbateGuide']) ? $_SESSION['isProbateGuide'] : 0;
?>
